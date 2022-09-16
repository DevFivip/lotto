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

        if (count($request->all()) > 1) {
            $data = $request->all();
            $dt = new DateTime($data['fecha_inicio'] . " 00:00:00", new DateTimeZone('UTC'));
            if (isset($data['fecha_fin'])) {
                $dt2 = new DateTime($data['fecha_fin'] . " 00:00:00", new DateTimeZone('UTC'));
                // $dt2->setTimezone(new DateTimeZone(session('timezone')));
            }
        } else {
            $dt = new DateTime(date('Y-m-d H:i:s'), new DateTimeZone('UTC'));
            // $dt->setTimezone(new DateTimeZone(session('timezone')));
        }

        //dd($dt->format('Y-m-d'));

        // cantidad de tickets generados el dia de hoy
        // Balance 

        $reports = [];
        $usuarios = [];


        $administradores = User::where('role_id', 2)->get();

        if (auth()->user()->role_id == 1) {

            if (!isset($data['fecha_inicio']) && !isset($data['fecha_fin'])) {
                $animalesvendidos = RegisterDetail::with('usuario', 'schedule', 'animal')->where('created_at', '>=', $dt->format('Y-m-d') . ' 00:00:00');
                $animalesvendidos = $animalesvendidos->where('created_at', '<=', $dt->format('Y-m-d') . ' 23:59:59');
            }

            if (isset($data['fecha_inicio']) && !isset($data['fecha_fin'])) {
                $animalesvendidos = RegisterDetail::with('usuario', 'schedule', 'animal')->where('created_at', '>=', $dt->format('Y-m-d') . ' 00:00:00');
                $animalesvendidos = $animalesvendidos->where('created_at', '<=', $dt->format('Y-m-d') . ' 23:59:59');
            }

            if (isset($data['fecha_inicio']) && isset($data['fecha_fin'])) {
                $animalesvendidos = RegisterDetail::with('usuario', 'schedule', 'animal')->where('created_at', '>=', $dt->format('Y-m-d') . ' 00:00:00');
                $animalesvendidos = $animalesvendidos->where('created_at', '<=', $dt2->format('Y-m-d') . ' 23:59:59');
            }

            $animalesvendidos = $animalesvendidos->get();
            $usuarios = User::all()->toArray();
        }

        if (auth()->user()->role_id == 2) {

            if (!isset($data['fecha_inicio']) && !isset($data['fecha_fin'])) {
                $animalesvendidos = RegisterDetail::with('usuario', 'schedule', 'animal')->where('admin_id', auth()->user()->id)->where('created_at', '>=', $dt->format('Y-m-d') . ' 00:00:00');
                $animalesvendidos = $animalesvendidos->where('created_at', '<=', $dt->format('Y-m-d') . ' 23:59:59');
            }

            if (isset($data['fecha_inicio']) && !isset($data['fecha_fin'])) {
                $animalesvendidos = RegisterDetail::with('usuario', 'schedule', 'animal')->where('admin_id', auth()->user()->id)->where('created_at', '>=', $dt->format('Y-m-d') . ' 00:00:00');
                $animalesvendidos = $animalesvendidos->where('created_at', '<=', $dt->format('Y-m-d') . ' 23:59:59');
            }

            if (isset($data['fecha_inicio']) && isset($data['fecha_fin'])) {
                $animalesvendidos = RegisterDetail::with('usuario', 'schedule', 'animal')->where('admin_id', auth()->user()->id)->where('created_at', '>=', $dt->format('Y-m-d') . ' 00:00:00');
                $animalesvendidos = $animalesvendidos->where('created_at', '<=', $dt2->format('Y-m-d') . ' 23:59:59');
            }

            $animalesvendidos = $animalesvendidos->get();
            // $animalesvendidos = RegisterDetail::with('usuario','schedule','animal')->where('admin_id', auth()->user()->id)->where('created_at', '>=', $dt->format('Y-m-d') . ' 00:00:00')->get();
            $usuarios = User::where('parent_id', auth()->user()->id)->get()->toArray();
        }

        if (auth()->user()->role_id == 3) {
            if (!isset($data['fecha_inicio']) && !isset($data['fecha_fin'])) {
                $animalesvendidos = RegisterDetail::with('usuario', 'schedule', 'animal')->where('user_id', auth()->user()->id)->where('created_at', '>=', $dt->format('Y-m-d') . ' 00:00:00');
                $animalesvendidos = $animalesvendidos->where('created_at', '<=', $dt->format('Y-m-d') . ' 23:59:59');
            }

            if (isset($data['fecha_inicio']) && !isset($data['fecha_fin'])) {
                $animalesvendidos = RegisterDetail::with('usuario', 'schedule', 'animal')->where('user_id', auth()->user()->id)->where('created_at', '>=', $dt->format('Y-m-d') . ' 00:00:00');
                $animalesvendidos = $animalesvendidos->where('created_at', '<=', $dt->format('Y-m-d') . ' 23:59:59');
            }

            if (isset($data['fecha_inicio']) && isset($data['fecha_fin'])) {
                $animalesvendidos = RegisterDetail::with('usuario', 'schedule', 'animal')->where('user_id', auth()->user()->id)->where('created_at', '>=', $dt->format('Y-m-d') . ' 00:00:00');
                $animalesvendidos = $animalesvendidos->where('created_at', '<=', $dt2->format('Y-m-d') . ' 23:59:59');
            }
            $animalesvendidos = $animalesvendidos->get();
            $usuarios = User::where('id', auth()->user()->id)->get()->toArray();
        }


        $monedas = Moneda::all()->toArray();
        $change = Exchange::all()->toArray();
        /**
         * @Array $TotalMonedas @Array $Change
         * return Array $totalMonedas
         */
        $totalMonedas =  $this->totalMonedas($monedas, $change, $animalesvendidos, $usuarios);

        // $totalMonedas =  $this->totalMonedas($monedas, $change, $animalesvendidos, $usuarios);
        $_start = [];

        if (auth()->user()->role_id == 1) {
            $_usuarios_admins = User::where('role_id', 2)->get()->toArray();
            foreach ($_usuarios_admins as $key => $usuario) {
                $__usuario = array($usuario);

                // dd($dt->format('Y-m-d'));
                // $__animalesvendidos = 
                // $__animalesvendidos = RegisterDetail::with('usuario', 'schedule', 'animal')->where('admin_id', $usuario["id"])->where('created_at', '>=', $dt->format('Y-m-d') . ' 00:00:00')->get();

                /**
                 * 
                 * CONDICIONES DEL BUSCADOR DE FECHAS
                 */
                if (!isset($data['fecha_inicio']) && !isset($data['fecha_fin'])) {
                    $__animalesvendidos = RegisterDetail::with('usuario', 'schedule', 'animal')->where('admin_id', $usuario["id"])->where('created_at', '>=', $dt->format('Y-m-d') . ' 00:00:00');
                    $__animalesvendidos = $__animalesvendidos->where('created_at', '<=', $dt->format('Y-m-d') . ' 23:59:59');
                }
                if (isset($data['fecha_inicio']) && !isset($data['fecha_fin'])) {
                    $__animalesvendidos = RegisterDetail::with('usuario', 'schedule', 'animal')->where('admin_id', $usuario["id"])->where('created_at', '>=', $dt->format('Y-m-d') . ' 00:00:00');
                    $__animalesvendidos = $__animalesvendidos->where('created_at', '<=', $dt->format('Y-m-d') . ' 23:59:59');
                }
                if (isset($data['fecha_inicio']) && isset($data['fecha_fin'])) {
                    $__animalesvendidos = RegisterDetail::with('usuario', 'schedule', 'animal')->where('admin_id', $usuario["id"])->where('created_at', '>=', $dt->format('Y-m-d') . ' 00:00:00');
                    $__animalesvendidos = $__animalesvendidos->where('created_at', '<=', $dt2->format('Y-m-d') . ' 23:59:59');
                }
                $__animalesvendidos = $__animalesvendidos->get();


                $_usuariototalMonedas =  $this->totalMonedas($monedas, $change, $__animalesvendidos, $__usuario);
                $_usuariototalMonedas['usuario'] = $usuario;
                // dd($_usuariototalMonedas);
                array_push($_start, $_usuariototalMonedas);
            }
        }
      
        if (auth()->user()->role_id == 2) {
            $_usuarios_taquilla = User::where("parent_id",auth()->user()->id)->where('role_id', 3)->get()->toArray();
            foreach ($_usuarios_taquilla as $key => $usuario) {
                $__usuario = array($usuario);

                // dd($dt->format('Y-m-d'));
                // $__animalesvendidos = 
                // $__animalesvendidos = RegisterDetail::with('usuario', 'schedule', 'animal')->where('admin_id', $usuario["id"])->where('created_at', '>=', $dt->format('Y-m-d') . ' 00:00:00')->get();

                /**
                 * 
                 * CONDICIONES DEL BUSCADOR DE FECHAS
                 */
                if (!isset($data['fecha_inicio']) && !isset($data['fecha_fin'])) {
                    $__animalesvendidos = RegisterDetail::with('usuario', 'schedule', 'animal')->where('admin_id', $usuario["id"])->where('created_at', '>=', $dt->format('Y-m-d') . ' 00:00:00');
                    $__animalesvendidos = $__animalesvendidos->where('created_at', '<=', $dt->format('Y-m-d') . ' 23:59:59');
                }
                if (isset($data['fecha_inicio']) && !isset($data['fecha_fin'])) {
                    $__animalesvendidos = RegisterDetail::with('usuario', 'schedule', 'animal')->where('admin_id', $usuario["id"])->where('created_at', '>=', $dt->format('Y-m-d') . ' 00:00:00');
                    $__animalesvendidos = $__animalesvendidos->where('created_at', '<=', $dt->format('Y-m-d') . ' 23:59:59');
                }
                if (isset($data['fecha_inicio']) && isset($data['fecha_fin'])) {
                    $__animalesvendidos = RegisterDetail::with('usuario', 'schedule', 'animal')->where('admin_id', $usuario["id"])->where('created_at', '>=', $dt->format('Y-m-d') . ' 00:00:00');
                    $__animalesvendidos = $__animalesvendidos->where('created_at', '<=', $dt2->format('Y-m-d') . ' 23:59:59');
                }
                $__animalesvendidos = $__animalesvendidos->get();


                $_usuariototalMonedas =  $this->totalMonedas($monedas, $change, $__animalesvendidos, $__usuario);
                $_usuariototalMonedas['usuario'] = $usuario;
                // dd($_usuariototalMonedas);
                array_push($_start, $_usuariototalMonedas);
            }
        }

        $groups = $animalesvendidos->groupBy('schedule_id');

        $list_plays =  $groups->map(function ($group, $k) {
            $animals_groups = $group->groupBy('animal_id');

            $g = $animals_groups->map(function ($gr) {

                if ($gr[0]->schedule()->first()->status == 1) {
                    return [$gr[0]->animal->number, $gr[0]->animal->nombre, $gr->count()];
                } else {
                    return [null, 0, 0];
                }
            });
            $g = $g->sortByDesc(2);
            $g = $g->slice(0, 7);

            return [$g, 'schedule' => $group[0]->schedule];

            // dd($g);

            // dd($animals_groups);
            // $_groups = $animals_groups->map(function($a,$l){
            //     return [$a->animal->nombre,$a->count()];
            // });

            // dd($_groups);
        });

        // dd($_start);

        return view('home', compact('totalMonedas', 'list_plays', '_start'));
    }

    public function totalMonedas($totalMonedas, $change, $animalesvendidos, $usuarios)
    {

        foreach ($animalesvendidos as $animalvendido) {
            //obtener el index de cada moneda
            $key =  array_search($animalvendido->moneda_id, array_column($totalMonedas, 'id'));
            $key2 =  array_search($animalvendido->moneda_id, array_column($change, 'moneda_id'));
            $user_key =  array_search($animalvendido->user_id, array_column($usuarios, 'id'));

            if (!isset($totalMonedas[$key]['total'])) {
                // dd($animalvendido->usuario);
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

        //calcular comisiones y perdidas
        foreach ($totalMonedas as $_key => $totales) {

            if (isset($totales['total'])) {
                // dd($totales);
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

        return $totalMonedas;
    }
}
