<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\Moneda;
use App\Models\Schedule;
use App\Models\SorteosType;
use App\Models\Tripleta;
use App\Models\TripletaDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Codedge\Fpdf\Fpdf\Fpdf;
use DateTime;
use DateTimeZone;

class TripletaController extends Controller
{

    protected $fpdf;

    public function __construct()
    {
        $this->fpdf = new Fpdf;
        $this->middleware('auth');
        $this->middleware('timezone');
        $this->resource = 'tripletas';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = $request->query();

        if (auth()->user()->role_id == 1) {
            $tripletas = Tripleta::with(['user', 'moneda', 'detalles'])->orderBy('id', 'desc');

            if (isset($filter['status'])) {
                $tripletas = $tripletas->where('status', $filter['status']);
            }
            if (isset($filter['has_winner'])) {
                $tripletas = $tripletas->where('has_winner', $filter['has_winner']);
            }

            if (isset($filter['moneda_id'])) {
                $tripletas = $tripletas->where('moneda_id', $filter['moneda_id']);
            }
            if (isset($filter['user_id'])) {
                $tripletas = $tripletas->where('user_id', $filter['user_id']);
            }
            if (isset($filter['created_at_inicio'])) {
                $tripletas = $tripletas->where('created_at', '>=', $filter['created_at_inicio'] . ' 00:00:00');
            }
            if (isset($filter['created_at_final'])) {
                $tripletas = $tripletas->where('created_at', '<=', $filter['created_at_final'] . ' 23:59:59');
            }
            $usuarios = User::orderBy('taquilla_name', 'desc')->get();
            $tripletas = $tripletas->paginate(isset($filter['_perPage']) ? $filter['_perPage'] : 10)->appends(request()->query());
        } elseif (auth()->user()->role_id == 2) {
            $tripletas = Tripleta::with(['user', 'moneda', 'detalles'])->where('admin_id', auth()->user()->id)->orderBy('id', 'desc');

            if (isset($filter['status'])) {
                $tripletas = $tripletas->where('status', $filter['status']);
            }
            if (isset($filter['has_winner'])) {
                $tripletas = $tripletas->where('has_winner', $filter['has_winner']);
            }

            if (isset($filter['moneda_id'])) {
                $tripletas = $tripletas->where('moneda_id', $filter['moneda_id']);
            }
            if (isset($filter['user_id'])) {
                $tripletas = $tripletas->where('user_id', $filter['user_id']);
            }
            if (isset($filter['created_at_inicio'])) {
                $tripletas = $tripletas->where('created_at', '>=', $filter['created_at_inicio'] . ' 00:00:00');
            }
            if (isset($filter['created_at_final'])) {
                $tripletas = $tripletas->where('created_at', '<=', $filter['created_at_final'] . ' 23:59:59');
            }
            $tripletas = $tripletas->paginate(isset($filter['_perPage']) ? $filter['_perPage'] : 10)->appends(request()->query());
            $usuarios = User::where('parent_id', auth()->user()->id)->orderBy('taquilla_name', 'desc')->get();
        } elseif (auth()->user()->role_id == 3) {
            $tripletas = Tripleta::with(['user', 'moneda', 'detalles'])->where('user_id', auth()->user()->id)->where('status', 1)->orderBy('id', 'desc');

            if (isset($filter['status'])) {
                $tripletas = $tripletas->where('status', $filter['status']);
            }
            if (isset($filter['has_winner'])) {
                $tripletas = $tripletas->where('has_winner', $filter['has_winner']);
            }

            if (isset($filter['moneda_id'])) {
                $tripletas = $tripletas->where('moneda_id', $filter['moneda_id']);
            }
            if (isset($filter['user_id'])) {
                $tripletas = $tripletas->where('user_id', $filter['user_id']);
            }
            if (isset($filter['created_at_inicio'])) {
                $tripletas = $tripletas->where('created_at', '>=', $filter['created_at_inicio'] . ' 00:00:00');
            }
            if (isset($filter['created_at_final'])) {
                $tripletas = $tripletas->where('created_at', '<=', $filter['created_at_final'] . ' 23:59:59');
            }
            $tripletas = $tripletas->paginate(isset($filter['_perPage']) ? $filter['_perPage'] : 10)->appends(request()->query());
            $usuarios = null;
        }



        $tripless =  $tripletas->each(function ($tripletas) {

            $tripletas->total_premios = $tripletas->detalles->sum(function ($item) {
                // dd($item->toArray());
                if ($item->animal_1_has_win == 1 && $item->animal_2_has_win == 1 && $item->animal_3_has_win == 1) {
                    return  floatval($item->total * 50);
                } else {
                    return 0;
                }
            });
            $tripletas->total_premios_pagados = $tripletas->detalles->sum(function ($item) {


                if ($item->winner == 1 &&  $item->status == 1) {
                    return  floatval($item->total * 50);
                } else {
                    return 0;
                }
            });

            $tripletas->total_premios_pendientes = $tripletas->total_premios - $tripletas->total_premios_pagados;
            return $tripletas;
        });

        // dd($tripless);

        $monedas = Moneda::whereIn('id', auth()->user()->monedas)->get();
        return view('tripletas.index', compact('tripletas', 'monedas', 'filter', 'usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if (auth()->user()->status == 0) {
            return redirect('/tripletas')->withErrors('⚠️ Usuario desactivado contactate con tu proveedor');
        }

        if (auth()->user()->role_id == 1) {
            return redirect('/tripletas')->withErrors('⚠️ Los Administradores no pueden crear tripletas');
        }

        if (auth()->user()->role_id == 2) {
            return redirect('/tripletas')->withErrors('⚠️ Los Administradores no pueden crear tripletas');
        }

        if (auth()->user()->sorteos == null) {
            $sorteos = SorteosType::where('status', 1)->get();
        } else {
            $sorteos = SorteosType::whereIn('id', auth()->user()->sorteos)->where('status', 1)->get();
        }

        $monedas = Moneda::whereIn('id', auth()->user()->monedas)->get();

        return view('tripletas.create', compact('monedas', 'sorteos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        return DB::transaction(function () use ($request) {

            $data = $request->all();
            $user = auth()->user();
            $caja = Caja::select(['id'])->where('user_id', $user->id)->where('status', 1)->first();

            if (isset($data['total']) && isset($data['detalles']) && isset($data['moneda']) && !!count($data['detalles'])) {

                $tripleta = Tripleta::create([
                    'code' => Str::random(10),
                    'caja_id' => $caja->id,
                    'user_id' => $user->id,
                    'admin_id' => $user->parent_id,
                    'total' => $data['total'],
                    'moneda_id' => $data['moneda'],
                    'status' => 1,
                ]);

                for ($i = 0; $i < count($data['detalles']); $i++) {

                    $triple = $data['detalles'][$i];

                    $schedules = Schedule::where('sorteo_type_id', $triple['_sorteo_type'])->orderBy('id', 'ASC')->get();

                    $primerSorteo = $schedules->filter(function ($k, $v) {

                        $hora_limite = $k->interval_end_utc;


                        $hora_limite = explode(" ", $hora_limite);

                        $actual = new DateTime(date('H:i:s'), new DateTimeZone('America/Caracas'));
                        $limite = new Datetime($hora_limite[1], new DateTimeZone('America/Caracas'));
       

                        if ($k->status == 1) {
                            if ($actual > $limite) {
                                $k->sorteos_left = 12;
                                $k->positionIndex = $v;
                                return $k;
                            } else {
                                $k->sorteos_left = 11;
                                $k->positionIndex = $v;
                                return $k;
                            }
                        }
                    });
  

                    $cantidad = $schedules->count();
                    $horarios =  $schedules->toArray();
                    $horarios2 =  $schedules->toArray();
                    $horarios3 =  $schedules->toArray();

                    $h = array_merge($horarios, $horarios2);
                    $h2 = array_merge($h, $horarios3);

                    $ii = $primerSorteo->first()->positionIndex + 10;
                    $ultimoSorteo = $h2[$ii];


             

                   TripletaDetail::create([
                        'tripleta_id' => $tripleta->id,
                        'animal_1' => $triple['_1ero'],
                        'animal_2' => $triple['_2do'],
                        'animal_3' => $triple['_3ero'],
                        'position_last_sorteo' => 0,
                        'sorteo_id' => $triple['_sorteo_type'],
                        'total' => $triple['_monto'],
                        'sorteo_left' => $primerSorteo->first()->sorteos_left,
                        'primer_sorteo' => $primerSorteo->first()->schedule,
                        'ultimo_sorteo' => $ultimoSorteo['schedule'],
                    ]);





                }

                return response()->json(['valid' => true, 'message' => ['Ticket guardado'], 'code' => $tripleta->code], 200);
            } else {
                return response()->json(["valid" => false, 'messages' => ['Seleccione moneda y al menos un Animalito']], 403);
            }
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function print(Request $request, $code)
    {

        $data = $request->all();

        $ticket = Tripleta::with(['user', 'moneda', 'caja'])->where('code', $code)->first();
        $dt = new DateTime($ticket->created_at, new DateTimeZone('UTC'));
        $dt->setTimezone(new DateTimeZone($data['timezone']));

        $ticket_detalles = TripletaDetail::with(['sorteo'])->where('tripleta_id', $ticket->id)->orderBy('tripleta_id', 'ASC')->get();


        $height = 100;

        $cant_items = $ticket_detalles->count();


        if ($cant_items > 6) {
            $sum = 6 * $cant_items;
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

        $line_start = 23;
        $spacing = 3.5;

        foreach ($ticket_detalles as $detalle) {
            // dd($detalle->total);
            $line_start += 1;

            $line_start += $spacing;
            $this->fpdf->SetFont('Arial', 'B', 12);
            $this->fpdf->Text(2, $line_start, $detalle->animal_1 . " " . $detalle->animal_2 . " " . $detalle->animal_3);
            $this->fpdf->SetFont('Arial');
            // $this->fpdf->Text(2, $line_start + 5, 'Total');
            $this->fpdf->Text(40, $line_start, $ticket->moneda->simbolo . ' ' . number_format($detalle->total, 2, ".", ","));
            $line_start += $spacing;
            $this->fpdf->Text(2, $line_start, $detalle->sorteo->name . ' '.$detalle->primer_sorteo. ' '.$detalle->ultimo_sorteo );

            $line_start += $spacing - 1.5;
        }


        // for ($i = 0; $i < count($sorteos_keys); $i++) {


        //     $sorteo = $ticket_detalles[$sorteos_keys[$i]];
        //     $horarios_keys = array_keys($sorteo->toArray());

        //     for ($e = 0; $e < count($horarios_keys); $e++) {
        //         $horario = $sorteo[$horarios_keys[$e]];
        //         $this->fpdf->SetFont('Arial', 'B', 11);
        //         $this->fpdf->Text(2, $line_start, $horario[0]->type->name . " " . $horario[0]->schedule);
        //         $this->fpdf->SetFont('Arial');

        //         $line_start += $spacing;

        //         for ($h = 0; $h < count($horario); $h++) {
        //             $item = $horario[$h];

        //             $this->fpdf->Text(2, $line_start, $item->animal->number . " " . $item->animal->nombre);
        //             $this->fpdf->Text(50, $line_start, $ticket->moneda->simbolo . ' ' . number_format($item->monto, 2, ".", ","));
        //             $line_start += $spacing;

        //         }
        //     }
        // }

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
        $this->fpdf->Text(9, $line_start + 22, 'Ticket Valido para los Proximos 11 sorteos');

        // $this->fpdf->Text(20, $line_start + 26, 'Consulta resultados en');
        // $this->fpdf->Text(22, $line_start + 30, 'www.lottoactivo.com');
        // $this->fpdf->Text(15, $line_start + 34, 'https://t.me/resultadosanimalitos');

        $this->fpdf->Output('ticket-' . $code . '.pdf', 'I');

        exit;
    }

    public function pay()
    {
    }

    public function destroy($id)
    {
        if (auth()->user()->role_id != 1) {
            $triple = Tripleta::where('code', $id)->first();
            $id = $triple->id;
            $res = DB::select("select * from tripleta_details where tripleta_id = $id and sorteo_left < 11");

            if (count($res) != 0) {
                return response()->json(['valid' => false, 'message' => 'No se puede eliminar esta tripleta, ya se encuentra en juego'], 403);
            };

            $detalles = TripletaDetail::where('tripleta_id', $id)->get();
            $detalles->each(function ($item) {
                $item->delete();
            });

            $triple->status = 0;
            $triple->update();

            return response()->json(['valid' => true, 'message' => 'Ticket eliminado perfectamente'], 200);
        } else {

            $triple = Tripleta::where('code', $id)->first();

            $id = $triple->id;
            $res = DB::select("select * from tripleta_details where tripleta_id = $id and sorteo_left < 11");

            $detalles = TripletaDetail::where('tripleta_id', $id)->get();
            $detalles->each(function ($item) {
                $item->delete();
            });

            $triple->status = 0;
            $triple->update();

            return response()->json(['valid' => true, 'message' => 'Ticket eliminado desde administrador perfectamente'], 200);
        }
    }
}
