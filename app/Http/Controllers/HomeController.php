<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\Exchange;
use App\Models\Moneda;
use App\Models\Register;
use App\Models\RegisterDetail;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->comision_vendedores = 0.13;
        $this->amount_rewards = 30; //numero por que se multiplica los premios
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // cantidad de tickets generados el dia de hoy
        // Balance 
        $cajas = [];
        if (auth()->user()->role_id == 1) {
            $animalesvendidos = RegisterDetail::where('created_at', '>=', date('Y-m-d') . ' 00:00:00')->get();
            $cajas = Caja::with('usuario')->where('status', 1)->get()->toArray();
        }

        if (auth()->user()->role_id == 2) {
            $animalesvendidos = RegisterDetail::where('admin_id', auth()->user()->id)->where('created_at', '>=', date('Y-m-d') . ' 00:00:00')->get();
            $cajas = Caja::with('usuario')->where('admin_id', auth()->user()->id)->get()->toArray();
            // dd($cajas);
        }

        if (auth()->user()->role_id == 3) {
            $animalesvendidos = RegisterDetail::where('user_id', auth()->user()->id)->where('created_at', '>=', date('Y-m-d') . ' 00:00:00')->get();
            // $cajas = Caja::with('usuario')->where('status', 1)->get()->toArray();
        }


        $totalMonedas = Moneda::all()->toArray();
        $change = Exchange::all()->toArray();

        foreach ($animalesvendidos as $animalvendido) {

            //obtener el index de cada moneda
            $key =  array_search($animalvendido->moneda_id, array_column($totalMonedas, 'id'));
            $key2 =  array_search($animalvendido->moneda_id, array_column($change, 'moneda_id'));



            if (!isset($totalMonedas[$key]['total'])) {
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

        //calcular comisiones y perdidas
        foreach ($totalMonedas as $_key => $totales) {
            // dd($totales);
            if (isset($totales['total'])) {
                $totales['comision'] = $totales['total'] * $this->comision_vendedores;
                $totales['comision_exchange_usd'] = ($totales['total'] * $this->comision_vendedores) / $totales['exchange_usd'];
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


            // dd($totales['caja_id']);
            // dd($cajas);

            if (isset($totales['caja_id'])) {

                $caja_key =  array_search($totales['caja_id'], array_column($cajas, 'id'));

                if (!isset($cajas[$caja_key]['totales'])) {
                    $cajas[$caja_key]['totales'] = [];
                    array_push($cajas[$caja_key]['totales'], $totales);
                } else {
                    array_push($cajas[$caja_key]['totales'], $totales);
                }
            }
            // $caja[$caja_key]['totales'] = [];

            $totalMonedas[$_key] = $totales;
        }




        return view('home', compact('totalMonedas', 'cajas'));
    }
}
