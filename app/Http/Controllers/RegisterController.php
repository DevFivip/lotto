<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Caja;
use App\Models\Exchange;
use App\Models\Register;
use App\Models\RegisterDetail;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Codedge\Fpdf\Fpdf\Fpdf;
use DateTime;
use DateTimeZone;

class RegisterController extends Controller
{


    protected $fpdf;

    public function __construct()
    {
        $this->fpdf = new Fpdf;
        $this->middleware('auth');
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


    public function create(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $data = $request->all();
            $user = auth()->user();
            $caja = Caja::where('user_id', $user->id)->where('status', 1)->first();

            //validar
            if (isset($data['total']) && isset($data['detalles']) && isset($data['moneda']) && !!count($data['detalles'])) {
                $errors = [];
                //validar cada item
                for ($i = 0; $i < count($data['detalles']); $i++) {
                    $item = $data['detalles'][$i];
                    $res =  $this->validateItem($item['id'], $item['schedule_id']);
                    if (!$res['status']) {
                        array_push($errors, $res['messages']);
                    }
                }
                if (!!count($errors)) {
                    return response()->json(["valid" => false, 'messages' => $errors], 403);
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
                    RegisterDetail::create([
                        'register_id' => $registro->id,
                        'animal_id' => $animalito['id'],
                        'schedule_id' => $animalito['schedule_id'],
                        'schedule' => $animalito['schedule'],
                        'admin_id' => $user['parent_id'],
                        'monto' => $animalito['monto'],
                        'moneda_id' => $registro->moneda_id,
                        'user_id' => auth()->user()->id,
                        'caja_id' => $caja->id,
                    ]);
                }
                return response()->json(['valid' => true, 'message' => ['Ticket guardado'], 'code' => $registro->code], 200);
            } else {
                return response()->json(["valid" => false, 'messages' => ['Seleccione moneda y al menos un Animalito']], 403);
            }
        });
    }

    public function checkItem($animal_id, $horario_id)
    {
        $r = RegisterDetail::where('animal_id', $animal_id)->where('schedule_id', $horario_id)->where('created_at', '>=', date('Y-m-d') . ' 00:00:00')->get();
        $cantidad = $r->count();
        $exchange = Exchange::all()->toArray();

        $_mapexchange = [];

        foreach ($exchange as $key => $value) {
            array_push($_mapexchange, $value['id']);
        }

        $monto = 0;

        foreach ($r as $item) {
            $k = array_search($item->moneda_id, $_mapexchange);
            $_exchange = $exchange[$k];
            $change = $item->monto / $_exchange['change_usd'];
            $monto = $change + $monto;
        }
        return [$cantidad, $monto];
    }

    public function validateItem($animal_id, $horario_id)
    {
        $resp =  $this->checkItem($animal_id, $horario_id);
        $animal = Animal::find($animal_id);
        $horario = Schedule::find($horario_id);
        $err = [];

        if ($horario->status == 0) {
            array_push($err, '⛔ El sorteo ' . $horario->schedule . ' ya no se encuantra disponible ⛔');
        }

        if ($resp[0] > $animal->limit_cant) {
            array_push($err, 'Limite de venta de unidades de ' . ' ' . $animal->nombre . ' ' . 'a las ' . $horario->schedule . ' ha excedido, intente para otro horario');
        }

        if ($resp[1] > $animal->limit_price_usd) {
            array_push($err, 'Limite de venta de precio' . ' ' . $animal->nombre . ' ' . 'a las ' . $horario->schedule . ' ha excedido, intente para otro horario');
        }

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

        $ticket_detalles = RegisterDetail::with(['animal', 'schedule'])->where('register_id', $ticket->id)->orderBy('schedule_id', 'ASC')->get();

        $height = 100;

        $cant_items = count($ticket_detalles);

        if ($cant_items > 10) {
            $sum = 4 * $cant_items;
            $height = $height + $sum;
        }

        $this->fpdf->SetFont('Arial', 'B', 12);
        $this->fpdf->AddPage("P", [$height, '76']);
        $this->fpdf->Text(30, 5, $ticket->user->taquilla_name);
        $this->fpdf->Text(0, 7.5, "---------------------------------------------------------");
        $this->fpdf->Text(2, 11, "Codigo: $code");
        $this->fpdf->Text(2, 16, $dt->format('d/m/y H:i:s'));
        $this->fpdf->Text(2, 20.5, "Caja: " . $ticket->caja_id . " N:" . $ticket->id);
        $this->fpdf->Text(0, 23.2, "---------------------------------------------------------");

        $line_start = 30;
        $spacing = 4.5;
        for ($i = 0; $i < count($ticket_detalles); $i++) {
            $item = $ticket_detalles[$i];
            $this->fpdf->Text(2, $line_start, $item->animal->number . " " . $item->animal->nombre . " " . $item->schedule);
            $this->fpdf->Text(50, $line_start, $ticket->moneda->simbolo . ' ' . number_format($item->monto, 2, ".", ","));
            $line_start = $line_start + $spacing;
        }
        $this->fpdf->Text(0, $line_start + 1, "---------------------------------------------------------");
        $this->fpdf->Text(2, $line_start + 5, 'Total');
        $this->fpdf->Text(40, $line_start + 5, $ticket->moneda->currency . ' ' . $ticket->moneda->simbolo . ' ' . number_format($ticket->total, 2, ".", ","));

        $this->fpdf->Text(13, $line_start + 12, 'Ticket caduca en 3 dias');

        $this->fpdf->Output('ticket-' . $code . '.pdf', 'I');

        exit;
    }


    public function destroy(Request $request, $code)
    {

        // dd(date('Y-m-d'));
        $register = Register::where('code', $code)->where('created_at', '>=', date('Y-m-d') . ' 00:00:00')->first();
        // $register = Register::where('code', $code)->first();

        if (!!$register) {
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

        // dd(
        //     $detalles->count(),
        //     $valid->count()
        // );

        if ($detalles->count() != $valid->count()) {
            return response()->json(['valid' => false, 'message' => 'No se puede eliminar este ticket, ya un animalito se encuentra en sorteo'], 403);
        } else {


            $detalles->each(function ($item) {
                $item->delete();
            });
            $register->delete();

            return response()->json(['valid' => true, 'message' => 'Ticket eliminado perfectamente'], 200);
        }

        //verificar que los items esten en el horario




    }

    public function payAnimalito(Request $request, $id)
    {
        $r =  RegisterDetail::find($id);
        $r->status = 1;
        $r->update();

        return response()->json(['valid' => true], 200);
    }
}
