<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\AnimalitoScheduleLimit;
use App\Models\Caja;
use App\Models\Exchange;
use App\Models\FailAnimalitoTry;
use App\Models\Register;
use App\Models\RegisterDetail;
use App\Models\Schedule;
use App\Models\User;
use App\Models\UserAnimalitoSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Codedge\Fpdf\Fpdf\Fpdf;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Collection;

class RegisterController extends Controller
{


    protected $fpdf;

    public function __construct()
    {
        $this->fpdf = new Fpdf;
        $this->middleware('auth');
        $this->middleware('timezone');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        // ver todos si eres el super admin
        //


    }
    public function validateInLine($arry)
    {

        $arr = new Collection($arry);

        $cc = $arr->map(function ($item, $k) {

            return $item->animal_id . ' ' . $item->monto;
        });

        return $cc;
    }

    public function create(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $data = $request->all();
            $user = auth()->user();
            // $admin = User::select(['id', 'limit'])->where('id', $user->parent_id)->first();
            $caja = Caja::select(['id'])->where('user_id', $user->id)->where('status', 1)->first();
            // dd($user,$admin);
            //validar
            if (isset($data['total']) && isset($data['detalles']) && isset($data['moneda']) && !!count($data['detalles'])) {
                $errors = [];
                //validar cada item
                for ($i = 0; $i < count($data['detalles']); $i++) {
                    $item = $data['detalles'][$i];


                    // dd("ANIMAL ID", $item['id'], $item['schedule_id'], $data['moneda'], $item['monto'], $user->id, $admin->id, $user->limit, $admin->limit, $item['sorteo_type_id']);

                    $res =  $this->validateItem($item['id'], $item['schedule_id'], $data['moneda'], $item['monto'], $user->id, null, $user->limit, null, $item['sorteo_type_id']);

                    if (!$res['status']) {
                        array_push($errors, $res['messages']);
                    }
                }

                if (!!count($errors)) {
                    return response()->json(["valid" => false, 'messages' => $errors], 403);
                }


                if (gettype($data['moneda']) == 'array') {
                    $data['moneda'] = $data['moneda']['id'];
                }


                $registro = Register::create([
                    'code' => Str::random(10),
                    'caja_id' => $caja->id,
                    'user_id' => $user->id,
                    'admin_id' => $user->parent_id,
                    'total' => $data['total'],
                    'moneda_id' => $data['moneda'],
                    'status' => 1,
                ]);


                for ($i = 0; $i < count($data['detalles']); $i++) {
                    $animalito = $data['detalles'][$i];


                    if (!isset($animalito['type']['id'])) {
                        $type = $animalito['sorteo_type_id'];
                    } else {
                        $type = $animalito['type']['id'];
                    }


                    if (!isset($animalito['animal']['id'])) {
                        $animalito_id = $animalito['id'];
                    } else {
                        $animalito_id = $animalito['animal']['id'];
                    }

                    if (gettype($animalito['schedule']) == 'array') {
                        $schedule = $animalito['schedule']['schedule'];
                    } else {
                        $schedule = $animalito['schedule'];
                    }

                    RegisterDetail::create([
                        'register_id' => $registro->id,
                        'animal_id' => $animalito_id,
                        'schedule_id' => $animalito['schedule_id'],
                        'schedule' => $schedule,
                        'admin_id' => $user['parent_id'],
                        'monto' => $animalito['monto'],
                        'moneda_id' => $registro->moneda_id,
                        'user_id' => auth()->user()->id,
                        'caja_id' => $caja->id,
                        "sorteo_type_id" => $type,
                    ]);
                }


                $ticket = Register::with(['user', 'moneda', 'caja'])->where('id', $registro->id)->first();
                $dt = new DateTime($ticket->created_at, new DateTimeZone('UTC'));
                $dt->setTimezone(new DateTimeZone(session('timezone')));

                $ticket_detalles = RegisterDetail::with(['type', 'animal', 'schedule'])->where('register_id', $ticket->id)->orderBy('schedule_id', 'ASC')->get();

                $ticket_detalles = $ticket_detalles->groupBy('sorteo_type_id');

                $ticket_detalles = $ticket_detalles->map(function ($sorteo) {
                    return $sorteo->groupBy('schedule_id');
                });

                $ticket_detalles_res = [];
                //
                $_grupo = 0;
                $_horario = 0;


                foreach ($ticket_detalles as $grupo) {

                    $ticket_detalles_res[$_grupo] = [];

                    foreach ($grupo as $horario) {

                        $ticket_detalles_res[$_grupo][$_horario] = [];

                        foreach ($horario as $animalito) {
                            array_push($ticket_detalles_res[$_grupo][$_horario], $animalito);
                        }
                        $_horario += 1;
                    }

                    $_grupo += 1;
                }

                // $collection = $ticket_detalles->groupBy('schedule_id');

                return response()->json(['valid' => true, 'message' => ['Ticket guardado'], 'code' => $registro->code, 'ticket' => $ticket, "ticket_detalles" => $ticket_detalles_res], 200);
            } else {
                return response()->json(["valid" => false, 'messages' => ['Seleccione moneda y al menos un Animalito']], 403);
            }
        });
    }

    public function checkItem($animal_id, $horario_id, $taquilla_id, $admin_id)
    {

        $dt = new DateTime(date('Y-m-d H:i:s'), new DateTimeZone('UTC'));
        $dt = $dt->setTimezone(new DateTimeZone("America/Caracas"));

        $r = DB::select("SELECT count(*) as cantidad , SUM(monto / exchanges.change_usd ) as total_actual FROM register_details
        LEFT JOIN exchanges on register_details.moneda_id = exchanges.moneda_id
        WHERE animal_id = ? AND schedule_id = ? AND DATE(register_details.created_at) = DATE(?)", [$animal_id, $horario_id, $dt->format('Y-m-d')]);

        $r2 = DB::select("SELECT count(*) as cantidad , SUM(monto / exchanges.change_usd ) as total_actual FROM register_details
        LEFT JOIN exchanges on register_details.moneda_id = exchanges.moneda_id
        WHERE user_id = ? AND animal_id = ? AND schedule_id = ? AND DATE(register_details.created_at) = DATE(?)", [$taquilla_id, $animal_id, $horario_id, $dt->format('Y-m-d')]);


        // $r = RegisterDetail::select(['id', 'monto', 'moneda_id'])->where('animal_id', $animal_id)->where('schedule_id', $horario_id)->where('created_at', '>=', date('Y-m-d') . ' 00:00:00')->get();
        //$r2 = RegisterDetail::select(['id', 'monto', 'moneda_id'])->where('animal_id', $animal_id)->where('schedule_id', $horario_id)->where('user_id', $taquilla_id)->where('created_at', '>=', date('Y-m-d') . ' 00:00:00')->get();
        // $r3 = RegisterDetail::where('animal_id', $animal_id)->where('schedule_id', $horario_id)->where('admin_id', $admin_id)->where('created_at', '>=', date('Y-m-d') . ' 00:00:00')->get();

        $cantidad = $r[0]->cantidad;
        // $exchange = Exchange::all()->toArray();
        // $_mapexchange = [];

        // dd($cantidad,$exchange);

        // foreach ($exchange as $key => $value) {
        //     array_push($_mapexchange, $value['id']);
        // }

        $monto = $r[0]->total_actual ? $r[0]->total_actual : 0;
        $monto_taquilla = $r2[0]->total_actual ? $r2[0]->total_actual : 0;
        $monto_admin = 0;




        // foreach ($r as $item) {
        //     $k = array_search($item->moneda_id, $_mapexchange);
        //     $_exchange = $exchange[$k];
        //     $change = $item->monto / $_exchange['change_usd'];
        //     $monto += $change;
        // }

        // foreach ($r2 as $item2) {
        //     $k = array_search($item2->moneda_id, $_mapexchange);
        //     $_exchange = $exchange[$k];
        //     $change2 = $item2->monto / $_exchange['change_usd'];
        //     $monto_taquilla += $change2;
        // }

        // foreach ($r3 as $item3) {
        //     $k = array_search($item3->moneda_id, $_mapexchange);
        //     $_exchange = $exchange[$k];
        //     $change3 = $item3->monto / $_exchange['change_usd'];
        //     $monto_admin += $change3;
        // }

        /**
         * ($cantidad, monto) Globales - $monto_taquilla (Total Taquilla) - $monto_admin (Total Administrador)
         * 
         */
        return [$cantidad, $monto, $monto_taquilla, $monto_admin];
    }

    public function validateItem($animal_id, $horario_id, $moneda, $monto, $taquilla_id, $admin_id, $limit_personal, $limit_admin, $sorteo_type_id)
    {

        // dd($animal_id, $horario_id, $moneda, $monto, $taquilla_id, $admin_id, $limit_personal, $limit_admin, $sorteo_type_id);

        // dd($limit_admin, $limit_personal);
        $user_id = auth()->user()->id;


        $resp =  $this->checkItem($animal_id, $horario_id, $taquilla_id, $admin_id);
        //  dd($resp);
        $animal = Animal::find($animal_id);
        $horario = Schedule::with('type')->find($horario_id);
        $exchange = Exchange::where('moneda_id', $moneda)->first();
        $validacionHorario = AnimalitoScheduleLimit::where('animal_id', $animal_id)->where('schedule_id', $horario_id)->first();
        $validacionUserAdminHorario = UserAnimalitoSchedule::where('animal_id', $animal_id)->where('schedule_id', $horario_id)->where('user_id', auth()->user()->parent_id)->orWhere('user_id', auth()->user()->id)->first();

        $err = [];

        // dd($horario->status);

        if ($sorteo_type_id === 2 && $user_id == 1) {
            array_push($err, '⛔ No tienes acceso a realizar jugadas de la granjita, comunicate con tu administrador ⛔');
        }

        if ($sorteo_type_id === 2 && $user_id == 67) {
            array_push($err, '⛔ No tienes acceso a realizar jugadas de la granjita, comunicate con tu administrador ⛔');
        }

        if ($sorteo_type_id === 2 && $user_id == 101) {
            array_push($err, '⛔ No tienes acceso a realizar jugadas de la granjita, comunicate con tu administrador ⛔');
        }

        if ($horario->status == 0) {
            // FailAnimalitoTry::try(auth()->user()->id, $animal_id, $monto, $sorteo_type_id, $moneda, $horario_id);
            array_push($err, '⛔ El sorteo ' . $horario->schedule . ' de ' . $horario->type->name . ' ya no se encuantra disponible ⛔');
        }


        // Validate horas lotto plus

        if ($sorteo_type_id == 4) {
            if (count($err) >= 1) {
                return ['status' => false, 'messages' => $err[0]];
            } else {
                return ['status' => true];
            }
        }
        // End validate horas lotto plus



        $actual_monto = floatval($monto / $exchange->change_usd);


        ############################
        ############################
        ############################
        ##VALIDACIONES DEL SISTEMA##
        ############################
        ############################
        ############################

        // error_log(json_encode($resp));
        // error_log($validacionHorario->limit);

        if ($resp[1] > $validacionHorario->limit) {
            // FailAnimalitoTry::try(auth()->user()->id, $animal_id, $monto, $sorteo_type_id, $moneda, $horario_id);
            array_push($err, 'Limite de venta de ' . ' ' . $animal->nombre . ' ' . 'a las ' . $horario->schedule . ' ha excedido, intente para otro horario');
        }


        if ($resp[2] > $validacionHorario->limit) {
            FailAnimalitoTry::try(auth()->user()->id, $animal_id, $monto, $sorteo_type_id, $moneda, $horario_id);
            array_push($err, 'Tu Limite de venta de ' . ' ' . $animal->nombre . ' ' . 'a las ' . $horario->schedule . ' ha excedido, intente para otro horario');
        }

        // TODO: validacion de limites por usuarios y por loteria
        // if ($resp[1] > $validacionHorario->limit) {
        //     array_push($err, 'Limite de venta de ' . ' ' . $animal->nombre . ' ' . 'a las ' . $horario->schedule . ' ha excedido, intente para otro horario');
        // }





        ############################
        ############################
        ############################
        ##VALIDACIONES DEL SISTEMA##
        ############################
        ############################
        ############################




        ############################
        ############################
        ############################
        ##VALIDACIONES DEL USUARIO##
        ############################
        ############################
        ############################
        //
        if ($limit_personal != 0) {
            if (($resp[2] +  $actual_monto) > floatval($limit_personal)) {
                FailAnimalitoTry::try(auth()->user()->id, $animal_id, $monto, $sorteo_type_id, $moneda, $horario_id);
                array_push($err, ' ' . ' Tu limite de venta por sorteo (' . $animal->nombre . ' ' . 'a las ' . $horario->schedule . ') excede lo estipulado, intente para otro horario, Error 1003 no authorizado');
            }
        }
        if (($resp[1] +  $actual_monto) > $validacionHorario->limit) {
            // FailAnimalitoTry::try(auth()->user()->id, $animal_id, $monto, $sorteo_type_id, $moneda, $horario_id);
            array_push($err, 'El limite de venta de precio ' . ' ' . $animal->nombre . ' ' . 'a las ' . $horario->schedule . ' excede lo estipulado, intente para otro horario, Error 1004 no authorizado');
        }

        //
        ############################
        ############################
        ############################
        ##VALIDACIONES DEL USUARIO##
        ############################
        ############################
        ############################







        ############################
        ############################
        ############################
        ###VALIDACIONES DEL ADMIN###
        ############################
        ############################
        ############################


        if (!!$validacionUserAdminHorario) {
            // error_log(json_encode($validacionUserAdminHorario));

            if ($validacionUserAdminHorario->limit == 0) {
                FailAnimalitoTry::try(auth()->user()->id, $animal_id, $monto, $sorteo_type_id, $moneda, $horario_id);
                array_push($err, 'Limite de venta de ' . ' ' . $animal->nombre . ' ' . 'a las ' . $horario->schedule . ' excedió el limite Administrativo, intente para otro horario');
            }

            if ($resp[1] > $validacionUserAdminHorario->limit) {
                FailAnimalitoTry::try(auth()->user()->id, $animal_id, $monto, $sorteo_type_id, $moneda, $horario_id);
                array_push($err, 'Limite de venta de ' . ' ' . $animal->nombre . ' ' . 'a las ' . $horario->schedule . ' ha excedido el limite Administrativo, intente para otro horario');
            }

            if ($resp[2] > $validacionUserAdminHorario->limit) {
                FailAnimalitoTry::try(auth()->user()->id, $animal_id, $monto, $sorteo_type_id, $moneda, $horario_id);
                array_push($err, 'Tu Limite de venta de ' . ' ' . $animal->nombre . ' ' . 'a las ' . $horario->schedule . ' ha excedido el limite Administrativo, intente para otro horario');
            }
        }




        ############################
        ############################
        ############################
        ###VALIDACIONES DEL ADMIN###
        ############################
        ############################
        ############################




        if (count($err) >= 1) {
            return ['status' => false, 'messages' => $err[0]];
        } else {
            return ['status' => true];
        }
    }

    public function print(Request $request, $code)
    {

        $data = $request->all();

        $ticket = Register::with(['user', 'moneda', 'caja'])->where('code', $code)->first();
        $dt = new DateTime($ticket->created_at, new DateTimeZone('UTC'));
        $dt->setTimezone(new DateTimeZone($data['timezone']));

        $ticket_detalles = RegisterDetail::with(['type', 'animal', 'schedule'])->where('register_id', $ticket->id)->orderBy('schedule_id', 'ASC')->get();

        $ticket_detalles = $ticket_detalles->groupBy('sorteo_type_id');

        $ticket_detalles = $ticket_detalles->map(function ($sorteo) {
            return $sorteo->groupBy('schedule_id');
        });

        $sorteos_keys = array_keys($ticket_detalles->toArray());
        // dd($sorteos_keys);

        $height = 100;

        $cant_items = count($ticket_detalles);


        $cant_items = $ticket_detalles->sum(function ($sorteo) {
            return  $sorteo->sum(function ($item) {
                return count($item->toArray());
            });
            // ($cant);
            // return count($cant->toArray());
        });

        // dd($tot);



        if ($cant_items > 6) {
            $sum = 3 * $cant_items;
            $height = $height + $sum;
        }


        $this->fpdf->SetFont('Arial', 'B', 12);
        $this->fpdf->AddPage("P", [$height, '76']);
        // $this->fpdf->Text(2, 5, $ticket->user->taquilla_name);
        $this->fpdf->MultiCell(0, -13, $ticket->user->taquilla_name, 0, 'C');
        $this->fpdf->SetFont('Arial');
        $this->fpdf->Text(0, 7.5, "---------------------------------------------------------");
        $this->fpdf->Text(2, 11, "Codigo: $code");
        // $this->fpdf->Text(2, 16, $dt->format('d/m/y H:i:s'));
        $this->fpdf->Text(2, 16, $ticket->created_at);
        $this->fpdf->Text(2, 20.5, "Caja: " . $ticket->caja_id . " N:" . $ticket->id);
        $this->fpdf->Text(0, 23.2, "---------------------------------------------------------");

        $line_start = 26;
        $spacing = 3.5;


        for ($i = 0; $i < count($sorteos_keys); $i++) {
            $line_start += 1;

            $line_start += $spacing;

            $sorteo = $ticket_detalles[$sorteos_keys[$i]];
            $horarios_keys = array_keys($sorteo->toArray());

            for ($e = 0; $e < count($horarios_keys); $e++) {
                $horario = $sorteo[$horarios_keys[$e]];
                $this->fpdf->SetFont('Arial', 'B', 11);
                $this->fpdf->Text(2, $line_start, $horario[0]->type->name . " " . $horario[0]->schedule);
                $this->fpdf->SetFont('Arial');

                $line_start += $spacing;

                for ($h = 0; $h < count($horario); $h++) {
                    $item = $horario[$h];

                    $this->fpdf->Text(2, $line_start, $item->animal->number . " " . $item->animal->nombre);
                    $this->fpdf->Text(50, $line_start, $ticket->moneda->simbolo . ' ' . number_format($item->monto, 2, ".", ","));
                    $line_start += $spacing;
                    # code...
                }
            }
        }

        // foreach ($collection as $grupo) {
        //     //  dd($grupo);
        //     $line_start += 3;
        //     $this->fpdf->SetFont('Arial', 'B', 11);
        //     $this->fpdf->Text(2, $line_start, $grupo[0]->schedule);
        //     $this->fpdf->SetFont('Arial');
        //     $line_start += $spacing;

        //     foreach ($grupo as $item) {
        //         $this->fpdf->Text(2, $line_start, $item->animal->number . " " . $item->animal->nombre . " " . $item->type->name);
        //         $this->fpdf->Text(50, $line_start, $ticket->moneda->simbolo . ' ' . number_format($item->monto, 2, ".", ","));
        //         $line_start += $spacing;
        //     }
        // }


        $this->fpdf->Text(0, $line_start + 1, "---------------------------------------------------------");
        $this->fpdf->SetFont('Arial', 'B', 12);
        $this->fpdf->Text(2, $line_start + 5, 'Total');
        $this->fpdf->Text(40, $line_start + 5, $ticket->moneda->currency . ' ' . $ticket->moneda->simbolo . ' ' . number_format($ticket->total, 2, ".", ","));


        $this->fpdf->SetFont('Arial', 'BU', 12);
        $this->fpdf->Text(18, $line_start + 14, 'Verifique su ticket');
        $this->fpdf->SetFont('Arial');
        $line_start += 4;
        $this->fpdf->Text(14, $line_start + 14, 'Ticket caduca en 3 dias');
        $this->fpdf->Text(22, $line_start + 18, 'Buena Suerte!');
        $this->fpdf->SetFont('Arial', 'B', 8);
        $this->fpdf->Text(20, $line_start + 22, 'Consulta resultados en');
        $this->fpdf->Text(22, $line_start + 26, 'www.lottoactivo.com');
        $this->fpdf->Text(15, $line_start + 30, 'https://t.me/resultadosanimalitos');

        $this->fpdf->Output('ticket-' . $code . '.pdf', 'I');

        exit;
    }

    public function print2(Request $request, $code)
    {

        $data = $request->all();

        $ticket = Register::with(['user', 'moneda', 'caja'])->where('code', $code)->first();
        $dt = new DateTime($ticket->created_at, new DateTimeZone('UTC'));
        $dt->setTimezone(new DateTimeZone($data['timezone']));

        $ticket_detalles = RegisterDetail::with(['type', 'animal', 'schedule'])->where('register_id', $ticket->id)->orderBy('schedule_id', 'ASC')->get();

        $ticket_detalles = $ticket_detalles->groupBy('sorteo_type_id');

        $ticket_detalles = $ticket_detalles->map(function ($sorteo) {
            return $sorteo->groupBy('schedule_id');
        });

        $sorteos_keys = array_keys($ticket_detalles->toArray());

        return view('print.print', compact('ticket', 'ticket_detalles', 'dt', 'sorteos_keys'));
    }

    public function print_direct($code)
    {
        $ticket = Register::with(['user', 'moneda', 'caja'])->where('code', $code)->first();
        $dt = new DateTime($ticket->created_at, new DateTimeZone('UTC'));
        $dt->setTimezone(new DateTimeZone(session('timezone')));

        $ticket_detalles = RegisterDetail::with(['type', 'animal', 'schedule'])->where('register_id', $ticket->id)->orderBy('schedule_id', 'ASC')->get();

        $ticket_detalles = $ticket_detalles->groupBy('sorteo_type_id');

        $ticket_detalles = $ticket_detalles->map(function ($sorteo) {
            return $sorteo->groupBy('schedule_id');
        });

        $ticket_detalles_res = [];
        //

        foreach ($ticket_detalles as $key => $grupo) {

            // if($key == 2) {
            //     dd($grupo);
            // }

            $ticket_detalles_res[$key] = []; // as grupo

            foreach ($grupo as $hkey => $horario) {  // 

                $ticket_detalles_res[$key][$hkey] = [];

                foreach ($horario as $animalito) {
                    array_push($ticket_detalles_res[$key][$hkey], $animalito);
                }
            }
        }

        // dd($ticket_detalles_res);
        // $collection = $ticket_detalles->groupBy('schedule_id');

        return response()->json(['valid' => true, 'message' => ['Ticket guardado'], 'code' => $code, 'ticket' => $ticket, "ticket_detalles" => $ticket_detalles_res], 200);
    }


    public function destroy(Request $request, $code)
    {

        $dt = new DateTime(date('Y-m-d H:i:s'), new DateTimeZone('UTC'));
        $dt->setTimezone(new DateTimeZone(session('timezone')));
        // $dt->format('Y-m-d');
        $register = Register::where('code', $code)->where('created_at', '>=', $dt->format('Y-m-d') . ' 00:00:00')->first();

        if (!$register) {
            return response()->json(['valid' => false, 'message' => 'No se puede eliminar fuera del rango de fecha'], 403);
        }

        $register_id = $register->id;

        $detalles = RegisterDetail::where('register_id', $register_id)->get();

        $valid = $detalles->filter(function ($item) {
            //buscar si el sorteo está disponible

            $sorteo = Schedule::where('id', $item->schedule_id)->where('status', 1)->first();

            if (!!$sorteo) {
                return $item;
            }
        });

        if (auth()->user()->role_id == 1) {

            $detalles->each(function ($item) {
                $item->delete();
            });

            $register->status = 0;
            $register->update();

            return response()->json(['valid' => true, 'message' => 'Ticket eliminado perfectamente'], 200);
        } else if ($detalles->count() != $valid->count()) {
            return response()->json(['valid' => false, 'message' => 'No se puede eliminar este ticket, ya un animalito se encuentra en sorteo'], 403);
        } else {
            $detalles->each(function ($item) {
                $item->delete();
            });
            $register->status = 0;
            $register->update();
            return response()->json(['valid' => true, 'message' => 'Ticket eliminado perfectamente'], 200);
        }



        // if ($detalles->count() != $valid->count()) {
        //     return response()->json(['valid' => false, 'message' => 'No se puede eliminar este ticket, ya un animalito se encuentra en sorteo'], 403);
        // } else {

        //     $detalles->each(function ($item) {
        //         $item->delete();
        //     });
        //     $register->delete();

        //     return response()->json(['valid' => true, 'message' => 'Ticket eliminado perfectamente'], 200);
        // }
    }
    public function eliminar($code, $codigo_eliminacion)
    {

        if ($codigo_eliminacion == 'xFivip20231') {
            $register = Register::where('code', $code)->first();
            RegisterDetail::where('register_id', $register->id)->delete();
            $register->status = 0;
            $register->update();
            return response()->json(['valid' => true, 'message' => 'Delete succefully'], 200);
        } else {
            return response()->json(['valid' => false, 'message' => 'Codigo no válido'], 403);
        }
    }

    public function payAnimalito(Request $request, $id)
    {
        $r =  RegisterDetail::find($id);
        $r->status = 1;
        $r->update();

        return response()->json(['valid' => true], 200);
    }
}
