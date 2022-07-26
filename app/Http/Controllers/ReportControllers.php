<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
use App\Models\Moneda;
use App\Models\RegisterDetail;
use App\Models\Schedule;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;

class ReportControllers extends Controller
{
    //
    public function __construct()
    {
        // $this->comision_vendedores = 0.13;
        $this->amount_rewards = 30;
        $this->middleware("timezone");
    }

    public function index(Request $request)
    {
        return view('reports.index');
    }

    public function general(Request $request)
    {

        $data  = $request->all();

        $fecha_inicio = isset($data['fecha_inicio']) ? $data['fecha_inicio'] : null;
        $fecha_fin = isset($data['fecha_fin']) ? $data['fecha_fin'] : null;

        if (is_null($fecha_inicio) && is_null($fecha_fin)) {
            $datas = [];
            return view('reports.general', compact('datas'));
        }

        $registersdetails = new RegisterDetail;

        if (auth()->user()->role_id == 2) {

            $registersdetails = $registersdetails->with('usuario')->where('admin_id', auth()->user()->id);
        }

        if (auth()->user()->role_id == 3) {
            $registersdetails = $registersdetails->with('usuario')->where('user_id', auth()->user()->id);
        }

        if ($fecha_inicio) {
            $registersdetails = $registersdetails->with('usuario')->where('created_at', '>=', $fecha_inicio  . ' 00:00:00');
        }

        if ($fecha_fin) {
            $registersdetails = $registersdetails->with('usuario')->where('created_at', '<=', $fecha_fin . ' 23:59:59');
        }

        // dd($registersdetails->toSql());

        $r = $registersdetails->get();

        $group = $r->groupBy('schedule_id');

        $fff =  $group->map(function ($v, $q) {
            $moneda = $v->groupBy('moneda_id');
            $_moneda = $moneda->map(function ($h, $k) {
                // dd($h, $k);
                $m = Moneda::find($k);
                $monto = $h->sum('monto');
                $premios = $h->sum(function ($p) {
                    $reward_porcent = 0;
                    switch ($p->sorteo_type_id) {
                        case 4:
                            $reward_porcent = 32;
                            break;

                        case 1:
                            $reward_porcent = 30;
                            break;

                        default:
                            $reward_porcent = 30;
                            break;
                    }

                    if ($p->winner == 1) {
                        return $p->monto * $reward_porcent;
                    }
                });

                $comision = $h->sum(function ($collection) {
                    return $collection->monto * ($collection->usuario->comision / 100);
                });
                return [$m->currency, $m->simbolo, $monto, $h->count(),  $comision, $premios];
            });
            $schedule = Schedule::find($q);
            $_moneda['sorteo'] = $schedule->schedule;
            return $_moneda;
        });

        $datas =  $fff;
        return view('reports.general', compact('datas'));
    }

    public function query(Request $request)
    {
    }

    public function personalStarts(Request $request)
    {
        $data = $request->all();
        $user_id = $data['user_id'];

        if (!isset($data['fecha_inicio']) && !isset($data['fecha_fin'])) {
            $dt = new DateTime(date('Y-m-d H:i:s'), new DateTimeZone('UTC'));
            $dt->setTimezone(new DateTimeZone(session('timezone')));
            $animalesvendidos = RegisterDetail::where('user_id', $user_id)->where('created_at', '>=', $dt->format('Y-m-d') . ' 00:00:00')->get();
        } else {
            if (!is_null($data['fecha_inicio']) && is_null($data['fecha_fin'])) {
                $animalesvendidos = RegisterDetail::where('user_id', $user_id)
                    ->where('created_at', '>=', $data['fecha_inicio'] . ' 00:00:00')
                    ->where('created_at', '<=', $data['fecha_inicio'] . ' 23:59:59')->get();
            }

            if (!is_null($data['fecha_inicio']) && !is_null($data['fecha_fin'])) {
                $animalesvendidos = RegisterDetail::where('user_id', $user_id)
                    ->where('created_at', '>=', $data['fecha_inicio'] . ' 00:00:00')
                    ->where('created_at', '<=', $data['fecha_fin'] . ' 23:59:59')->get();
            }
        }


        $totalMonedas = Moneda::all()->toArray();
        $change = Exchange::all()->toArray();

        foreach ($animalesvendidos as $animalvendido) {

            //obtener el index de cada moneda
            $key =  array_search($animalvendido->moneda_id, array_column($totalMonedas, 'id'));
            $key2 =  array_search($animalvendido->moneda_id, array_column($change, 'moneda_id'));

            if (!isset($totalMonedas[$key]['total'])) {
                $totalMonedas[$key]['_comision'] = $animalvendido->usuario->comision / 100;
                $totalMonedas[$key]['user_id'] = $animalvendido->user_id;
                $totalMonedas[$key]['caja_id'] = $animalvendido->caja_id;
                $totalMonedas[$key]['exchange_usd'] = $change[$key2]['change_usd'];
                $totalMonedas[$key]['total'] = $animalvendido->monto;
                $totalMonedas[$key]['total_exchange_usd'] = $animalvendido->monto / $change[$key2]['change_usd'];
            } else {
                $totalMonedas[$key]['total'] =  $totalMonedas[$key]['total'] + $animalvendido->monto;
                $totalMonedas[$key]['total_exchange_usd'] = ($animalvendido->monto / $change[$key2]['change_usd']) + $totalMonedas[$key]['total_exchange_usd'];
            }

            if (!isset($totalMonedas[$key]['total_rewards'])) {
                $totalMonedas[$key]['total_rewards'] = $animalvendido->winner == 1 ? $animalvendido->monto * $this->amount_rewards : 0.00;
            } else {
                $totalMonedas[$key]['total_rewards'] = $totalMonedas[$key]['total_rewards'] + ($animalvendido->winner == 1 ? $animalvendido->monto * $this->amount_rewards : 0.00);
            }

            if (!isset($totalMonedas[$key]['total_pay'])) {
                $totalMonedas[$key]['total_pay'] =  $animalvendido->status == 1 ? $animalvendido->monto * $this->amount_rewards : 0.00;
            } else {
                $totalMonedas[$key]['total_pay'] = $totalMonedas[$key]['total_pay'] + ($animalvendido->status == 1 ? $animalvendido->monto * $this->amount_rewards : 0.00);
            }
        }

        // dd($usuarios);

        //calcular comisiones y perdidas
        foreach ($totalMonedas as $_key => $totales) {
            // dd($totales);
            if (isset($totales['total'])) {
                $totales['comision'] = $totales['total'] * $totales['_comision'];
                $totales['comision_exchange_usd'] = ($totales['total'] * $totales['_comision']) / $totales['exchange_usd'];
            }

            if (isset($totales['total_rewards'])) {
                $totales['total_rewards_exchange_usd'] = $totales['total_rewards'] /  $totales['exchange_usd'];
                $totales['total_rewards_exchange_usd'] = $totales['total_rewards'] /  $totales['exchange_usd'];
            }

            if (isset($totales['total'])) {
                $totales['balance'] = $totales['total'] - $totales['total_rewards'] - $totales['comision'];
                $totales['balance_exchange_usd'] = $totales['total_exchange_usd'] - $totales['total_rewards_exchange_usd'] - $totales['comision_exchange_usd'];
            }

            if (isset($totales['total_pay'])) {
                $totales['total_pay_exchange_usd'] = $totales['total_pay'] /  $totales['exchange_usd'];
            }

            $totalMonedas[$_key] = $totales;
        }

        return response()->json($totalMonedas, 200);
    }
}
