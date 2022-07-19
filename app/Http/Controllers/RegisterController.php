<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Caja;
use App\Models\Exchange;
use App\Models\Register;
use App\Models\RegisterDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegisterController extends Controller
{

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
        //
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
                    ]);
                }

                return response()->json(['valid' => true, 'message' => ['Ticket guardado']], 200);
            } else {
                return response()->json(["valid" => false, 'messages' => ['Seleccione Moneda y al menos un Animalito']], 403);
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
        $err = [];

        if ($resp[0] > $animal->limit_cant) {
            array_push($err, 'el limite de venta de unidades de ' . ' ' . $animal->nombre . ' ' . 'ha excedido, intente para otro horario');
        }

        if ($resp[1] > $animal->limit_price_usd) {
            array_push($err, 'el limite de venta de precio' . ' ' . $animal->nombre . ' ' . 'ha excedido, intente para otro horario');
        }


        if (count($err) >= 1) {
            return ['status' => false, 'messages' => $err[0]];
        } else {
            return ['status' => true];
        }
    }


    public function destroy()
    {
        //
    }
}
