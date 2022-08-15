<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\Exchange;
use App\Models\Moneda;
use App\Models\Register;
use App\Models\RegisterDetail;
use App\Models\User;
use DateTime;
use DateTimeZone;
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
        $this->middleware('timezone');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

        if(count($request->all()) > 1)
        {   
            $data = $request->all();
            $dt = new DateTime($data['fecha_inicio']."00:00:00", new DateTimeZone('UTC'));

            if(isset($data['fecha_fin'])){
                $dt2 = new DateTime($data['fecha_fin']."00:00:00", new DateTimeZone('UTC'));
                $dt2->setTimezone(new DateTimeZone(session('timezone')));
            }
      
        }else{
            $dt = new DateTime(date('Y-m-d H:i:s'), new DateTimeZone('UTC'));
            $dt->setTimezone(new DateTimeZone(session('timezone')));
        }

        //dd($dt->format('Y-m-d'));

        // cantidad de tickets generados el dia de hoy
        // Balance 

        $reports = [];
        $usuarios = [];

        
        
        if (auth()->user()->role_id == 1) {
            
            if(!isset($data['fecha_inicio']) && !isset($data['fecha_fin']) ){
                $animalesvendidos = RegisterDetail::where('created_at', '>=', $dt->format('Y-m-d') . ' 00:00:00');
                $animalesvendidos = $animalesvendidos->where('created_at', '<=', $dt->format('Y-m-d') . ' 23:59:59');
            }
            
            if(isset($data['fecha_inicio']) && !isset($data['fecha_fin'])){
                $animalesvendidos = RegisterDetail::where('created_at', '>=', $dt->format('Y-m-d') . ' 00:00:00');
                $animalesvendidos = $animalesvendidos->where('created_at', '<=', $dt->format('Y-m-d') . ' 23:59:59');
            }
            
            if(isset($data['fecha_inicio']) && isset($data['fecha_fin'])){
                $animalesvendidos = RegisterDetail::where('created_at', '>=', $dt->format('Y-m-d') . ' 00:00:00');
                $animalesvendidos = $animalesvendidos->where('created_at', '<=', $dt2->format('Y-m-d') . ' 23:59:59');
            }

            // if(isset($data['fecha_fin'])){
            //     $animalesvendidos=    $animalesvendidos->where('created_at','>=',$dt2->format('Y-m-d').' 23:59:59');
            // }
            
            $animalesvendidos = $animalesvendidos->get();

            $ticketsvendidos = Register::where('created_at', '>=', $dt->format('Y-m-') . '01 00:00:00')->get();
            $usuarios = User::all()->toArray();
        }

        if (auth()->user()->role_id == 2) {

            if(!isset($data['fecha_inicio']) && !isset($data['fecha_fin']) ){
                $animalesvendidos = RegisterDetail::where('created_at', '>=', $dt->format('Y-m-d') . ' 00:00:00');
                $animalesvendidos = $animalesvendidos->where('created_at', '<=', $dt->format('Y-m-d') . ' 23:59:59');
            }
            
            if(isset($data['fecha_inicio']) && !isset($data['fecha_fin'])){
                $animalesvendidos = RegisterDetail::where('created_at', '>=', $dt->format('Y-m-d') . ' 00:00:00');
                $animalesvendidos = $animalesvendidos->where('created_at', '<=', $dt->format('Y-m-d') . ' 23:59:59');
            }
            
            if(isset($data['fecha_inicio']) && isset($data['fecha_fin'])){
                $animalesvendidos = RegisterDetail::where('created_at', '>=', $dt->format('Y-m-d') . ' 00:00:00');
                $animalesvendidos = $animalesvendidos->where('created_at', '<=', $dt2->format('Y-m-d') . ' 23:59:59');
            }

            $animalesvendidos = $animalesvendidos->get();
            // $animalesvendidos = RegisterDetail::where('admin_id', auth()->user()->id)->where('created_at', '>=', $dt->format('Y-m-d') . ' 00:00:00')->get();
            $usuarios = User::where('parent_id', auth()->user()->id)->get()->toArray();
            $ticketsvendidos = Register::where('admin_id', auth()->user()->id)->where('created_at', '>=', $dt->format('Y-m-') . '01 00:00:00')->get();
        }

        if (auth()->user()->role_id == 3) {
            if(!isset($data['fecha_inicio']) && !isset($data['fecha_fin']) ){
                $animalesvendidos = RegisterDetail::where('user_id', auth()->user()->id)->where('created_at', '>=', $dt->format('Y-m-d') . ' 00:00:00');
                $animalesvendidos = $animalesvendidos->where('created_at', '<=', $dt->format('Y-m-d') . ' 23:59:59');
            }
            
            if(isset($data['fecha_inicio']) && !isset($data['fecha_fin'])){
                $animalesvendidos = RegisterDetail::where('user_id', auth()->user()->id)->where('created_at', '>=', $dt->format('Y-m-d') . ' 00:00:00');
                $animalesvendidos = $animalesvendidos->where('created_at', '<=', $dt->format('Y-m-d') . ' 23:59:59');
            }
            
            if(isset($data['fecha_inicio']) && isset($data['fecha_fin'])){
                $animalesvendidos = RegisterDetail::where('user_id', auth()->user()->id)->where('created_at', '>=', $dt->format('Y-m-d') . ' 00:00:00');
                $animalesvendidos = $animalesvendidos->where('created_at', '<=', $dt2->format('Y-m-d') . ' 23:59:59');
            }
            //$animalesvendidos = RegisterDetail::where('user_id', auth()->user()->id)->where('created_at', '>=', $dt->format('Y-m-d') . ' 00:00:00')->get();
            $usuarios = User::where('id', auth()->user()->id)->get()->toArray();
            $ticketsvendidos = Register::where('user_id', auth()->user()->id)->where('created_at', '>=', $dt->format('Y-m-') . '01 00:00:00')->get();
            // $cajas = Caja::with('usuario')->where('status', 1)->get()->toArray();
        }
        // $animalesvendidos = $animalesvendidos->get();
        $reports['tickets_vendidos'] = $ticketsvendidos->count();
        $reports['tickets_numeros_vendidos'] = $animalesvendidos->count();

        // dd($reports);

        $totalMonedas = Moneda::all()->toArray();
        $change = Exchange::all()->toArray();

        foreach ($animalesvendidos as $animalvendido) {
            //obtener el index de cada moneda
            $key =  array_search($animalvendido->moneda_id, array_column($totalMonedas, 'id'));
            $key2 =  array_search($animalvendido->moneda_id, array_column($change, 'moneda_id'));
            $user_key =  array_search($animalvendido->user_id, array_column($usuarios, 'id'));

            if (!isset($totalMonedas[$key]['total'])) {
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

            $totalMonedas[$_key] = $totales;
        }

        // dd($totalMonedas);

        // foreach ($usuarios as $kkey => $usuario) {
        //     if (!isset($usuario['totales'])) {
        //         $usuario['totales'] = [];
        //     } else {
        //     }


        //     $usuarios[$kkey] = $usuario;
        // }

        // dd($usuarios);




        return view('home', compact('totalMonedas', 'usuarios'));
    }
}
