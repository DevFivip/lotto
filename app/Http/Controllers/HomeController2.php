<?php

namespace App\Http\Controllers;

use DateTime;
use DateTimeZone;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController2 extends Controller
{
    //
    public function index(Request $request)
    {
        if (count($request->all()) > 1) {
            $data = $request->all();
            $dt = new DateTime($data['fecha_inicio'] . " 00:00:00", new DateTimeZone('America/Caracas'));
            if (isset($data['fecha_fin'])) {
                $dt2 = new DateTime($data['fecha_fin'] . " 00:00:00", new DateTimeZone('America/Caracas'));
                // $dt2->setTimezone(new DateTimeZone(session('timezone')));
            }

        } else {
            $dt = new DateTime(date('Y-m-d H:i:s'), new DateTimeZone('UTC'));
            $dt = $dt->setTimezone(new DateTimeZone("America/Caracas"));
        }

        if (auth()->user()->role_id == 1) {

            if (!isset($data['fecha_inicio']) && !isset($data['fecha_fin'])) {
                $results = DB::select(DB::raw("SELECT user_id,register_details.moneda_id AS moneda,
                T1.name as admin_name,
                users.taquilla_name as taquilla_name,users.name,
                monedas.currency,monedas.simbolo,
                sorteos_types.name AS loteria_name,
    
                SUM(monto) AS monto_total,
                SUM(monto * (users.comision) / 100) AS comision_total,
                SUM(IF(register_details.winner = 1, (monto * sorteos_types.premio_multiplication) , 0 )) AS premio_total,
    
                SUM(monto / exchanges.change_usd ) AS usd_monto_total,
                SUM((monto * (users.comision) / 100) /  exchanges.change_usd) AS usd_comision_total,
                SUM(IF(register_details.winner = 1, (monto * sorteos_types.premio_multiplication) / exchanges.change_usd , 0 )) AS usd_premio_total,
    
                COUNT(*) AS animalitos_vendidos
                FROM register_details  
                LEFT JOIN monedas ON register_details.moneda_id = monedas.id
                LEFT JOIN exchanges ON register_details.moneda_id = exchanges.moneda_id
                LEFT JOIN users ON users.id = register_details.user_id
                LEFT JOIN users as T1 ON T1.id = register_details.admin_id
                LEFT JOIN sorteos_types ON register_details.sorteo_type_id = sorteos_types.id
                WHERE date(register_details.created_at) >= date(:fecha_inicio)   
                GROUP BY user_id ,register_details.moneda_id, register_details.sorteo_type_id
                ORDER BY user_id"), ['fecha_inicio' => $dt->format('Y-m-d')]);
            }



            if (isset($data['fecha_inicio']) && !isset($data['fecha_fin'])) {
                $results = DB::select(DB::raw("SELECT user_id,register_details.moneda_id AS moneda,
                     T1.name as admin_name,
            users.taquilla_name,users.name,
            monedas.currency,monedas.simbolo,
            sorteos_types.name AS loteria_name,

            SUM(monto) AS monto_total,
            SUM(monto * (users.comision) / 100) AS comision_total,
            SUM(IF(register_details.winner = 1, (monto * sorteos_types.premio_multiplication) , 0 )) AS premio_total,

            SUM(monto / exchanges.change_usd ) AS usd_monto_total,
            SUM((monto * (users.comision) / 100) /  exchanges.change_usd)  AS usd_comision_total,
            SUM(IF(register_details.winner = 1, (monto * sorteos_types.premio_multiplication) / exchanges.change_usd , 0 )) AS usd_premio_total,

            COUNT(*) AS animalitos_vendidos
            FROM register_details  
            LEFT JOIN monedas ON register_details.moneda_id = monedas.id
            LEFT JOIN exchanges ON register_details.moneda_id = exchanges.moneda_id
            LEFT JOIN users ON users.id = register_details.user_id
            LEFT JOIN users as T1 ON T1.id = register_details.admin_id
            LEFT JOIN sorteos_types ON register_details.sorteo_type_id = sorteos_types.id
            WHERE date(register_details.created_at) >= date(:fecha_inicio)   
            GROUP BY user_id ,register_details.moneda_id, register_details.sorteo_type_id
            ORDER BY user_id"), ['fecha_inicio' => $dt->format('Y-m-d')]);

                // dd($results);
            }


            if (isset($data['fecha_inicio']) && isset($data['fecha_fin'])) {

                // dd($dt->format('Y-m-d') . ' 00:00:00', $dt2->format('Y-m-d') . ' 23:59:59');
                $results = DB::select(DB::raw("SELECT user_id,register_details.moneda_id AS moneda,
            T1.name as admin_name,
            users.taquilla_name,users.name,
            monedas.currency,monedas.simbolo,
            sorteos_types.name AS loteria_name,

            SUM(monto) AS monto_total,
            SUM(monto * (users.comision) / 100) AS comision_total,
            SUM(IF(register_details.winner = 1, (monto * sorteos_types.premio_multiplication) , 0 )) AS premio_total,

            SUM(monto / exchanges.change_usd ) AS usd_monto_total,
            SUM((monto * (users.comision) / 100) /  exchanges.change_usd)  AS usd_comision_total,
            SUM(IF(register_details.winner = 1, (monto * sorteos_types.premio_multiplication) / exchanges.change_usd , 0 )) AS usd_premio_total,

            COUNT(*) AS animalitos_vendidos
            FROM register_details  
            LEFT JOIN monedas ON register_details.moneda_id = monedas.id
            LEFT JOIN exchanges ON register_details.moneda_id = exchanges.moneda_id
            LEFT JOIN users ON users.id = register_details.user_id
            LEFT JOIN users as T1 ON T1.id = register_details.admin_id
            LEFT JOIN sorteos_types ON register_details.sorteo_type_id = sorteos_types.id
            WHERE (DATE(register_details.created_at) BETWEEN DATE(:fecha_inicio) AND DATE(:fecha_fin))
            GROUP BY user_id ,register_details.moneda_id, register_details.sorteo_type_id
            ORDER BY user_id"), ['fecha_inicio' => $dt->format('Y-m-d') . ' 00:00:00', 'fecha_fin' =>  $dt2->format('Y-m-d') . ' 23:59:59']);
            }

            // dd($results);

            $results = collect($results);
            $g = $results->groupBy('admin_name');

            $gg = $g->map(function ($v) {
                $m = $v->groupBy('currency');
                $tm = $m->each(function ($e) {
                    $total_monto = $e->sum('monto_total');
                    $comision_total = $e->sum('comision_total');
                    $premio_total = $e->sum('premio_total');
                    $animalitos_vendidos = $e->sum('animalitos_vendidos');

                    // dd($total_monto,$comision_total,$premio_total,$animalitos_vendidos);
                    // $e-> totales = [
                    //     'total_monto' => $total_monto,
                    //     'comision_total' => $comision_total,
                    //     'premio_total' => $premio_total,
                    //     'animalitos_vendidos' => $animalitos_vendidos,
                    // ];

                    $r = collect([
                        'total_monto' => $total_monto,
                        'comision_total' => $comision_total,
                        'premio_total' => $premio_total,
                        'animalitos_vendidos' => $animalitos_vendidos,
                    ]);

                    $e->push($r);
                    return $e;
                });
                return $tm;

                // dd($tm);
                // dd($m);
                // dd($v);
                // $total = $v->sum(function($q){
                //     return $q->monto_total;
                // });
                // dd($total);

            });

            // dd($results);

            $balance_money_group = $results->groupBy('currency');

            $balance_general = $balance_money_group->each(function ($ghh) {

                $total_monto = $ghh->sum('monto_total');
                $comision_total = $ghh->sum('comision_total');
                $premio_total = $ghh->sum('premio_total');
                $animalitos_vendidos = $ghh->sum('animalitos_vendidos');


                $r2 = collect([
                    'total_monto' => $total_monto,
                    'comision_total' => $comision_total,
                    'premio_total' => $premio_total,
                    'animalitos_vendidos' => $animalitos_vendidos,
                ]);

                $ghh->push($r2);
                return $ghh;
            });


            return view('home2', compact('results', 'gg', 'balance_general'));
        }

        if (auth()->user()->role_id == 2) {

            if (!isset($data['fecha_inicio']) && !isset($data['fecha_fin'])) {
                $results = DB::select(DB::raw("SELECT user_id,register_details.moneda_id AS moneda,
                T1.name as admin_name,
                users.taquilla_name as taquilla_name,users.name,
                monedas.currency,monedas.simbolo,
                sorteos_types.name AS loteria_name,
    
                SUM(monto) AS monto_total,
                SUM(monto * (users.comision) / 100) AS comision_total,
                SUM(IF(register_details.winner = 1, (monto * sorteos_types.premio_multiplication) , 0 )) AS premio_total,
    
                SUM(monto / exchanges.change_usd ) AS usd_monto_total,
                SUM((monto * (users.comision) / 100) /  exchanges.change_usd) AS usd_comision_total,
                SUM(IF(register_details.winner = 1, (monto * sorteos_types.premio_multiplication) / exchanges.change_usd , 0 )) AS usd_premio_total,
    
                COUNT(*) AS animalitos_vendidos
                FROM register_details  
                LEFT JOIN monedas ON register_details.moneda_id = monedas.id
                LEFT JOIN exchanges ON register_details.moneda_id = exchanges.moneda_id
                LEFT JOIN users ON users.id = register_details.user_id
                LEFT JOIN users as T1 ON T1.id = register_details.admin_id
                LEFT JOIN sorteos_types ON register_details.sorteo_type_id = sorteos_types.id
                WHERE date(register_details.created_at) >= date(:fecha_inicio) 
                and register_details.admin_id = :admin_id
                GROUP BY user_id ,register_details.moneda_id, register_details.sorteo_type_id
                ORDER BY user_id"), ['fecha_inicio' => $dt->format('Y-m-d'), "admin_id" => auth()->user()->id]);
            }



            if (isset($data['fecha_inicio']) && !isset($data['fecha_fin'])) {
                $results = DB::select(DB::raw("SELECT user_id,register_details.moneda_id AS moneda,
            T1.name as admin_name,
            users.taquilla_name,users.name,
            monedas.currency,monedas.simbolo,
            sorteos_types.name AS loteria_name,

            SUM(monto) AS monto_total,
            SUM(monto * (users.comision) / 100) AS comision_total,
            SUM(IF(register_details.winner = 1, (monto * sorteos_types.premio_multiplication) , 0 )) AS premio_total,

            SUM(monto / exchanges.change_usd ) AS usd_monto_total,
            SUM((monto * (users.comision) / 100) /  exchanges.change_usd)  AS usd_comision_total,
            SUM(IF(register_details.winner = 1, (monto * sorteos_types.premio_multiplication) / exchanges.change_usd , 0 )) AS usd_premio_total,

            COUNT(*) AS animalitos_vendidos
            FROM register_details  
            LEFT JOIN monedas ON register_details.moneda_id = monedas.id
            LEFT JOIN exchanges ON register_details.moneda_id = exchanges.moneda_id
            LEFT JOIN users ON users.id = register_details.user_id
            LEFT JOIN users as T1 ON T1.id = register_details.admin_id
            LEFT JOIN sorteos_types ON register_details.sorteo_type_id = sorteos_types.id
            WHERE date(register_details.created_at) >= date(:fecha_inicio) 
            and register_details.admin_id = :admin_id
            GROUP BY user_id ,register_details.moneda_id, register_details.sorteo_type_id
            ORDER BY user_id"), ['fecha_inicio' => $dt->format('Y-m-d'), "admin_id" => auth()->user()->id]);

                // dd($results);
            }


            if (isset($data['fecha_inicio']) && isset($data['fecha_fin'])) {

                // dd($dt->format('Y-m-d') . ' 00:00:00', $dt2->format('Y-m-d') . ' 23:59:59');
                $results = DB::select(DB::raw("SELECT user_id,register_details.moneda_id AS moneda,
            T1.name as admin_name,
            users.taquilla_name,users.name,
            monedas.currency,monedas.simbolo,
            sorteos_types.name AS loteria_name,

            SUM(monto) AS monto_total,
            SUM(monto * (users.comision) / 100) AS comision_total,
            SUM(IF(register_details.winner = 1, (monto * sorteos_types.premio_multiplication) , 0 )) AS premio_total,

            SUM(monto / exchanges.change_usd ) AS usd_monto_total,
            SUM((monto * (users.comision) / 100) /  exchanges.change_usd)  AS usd_comision_total,
            SUM(IF(register_details.winner = 1, (monto * sorteos_types.premio_multiplication) / exchanges.change_usd , 0 )) AS usd_premio_total,

            COUNT(*) AS animalitos_vendidos
            FROM register_details  
            LEFT JOIN monedas ON register_details.moneda_id = monedas.id
            LEFT JOIN exchanges ON register_details.moneda_id = exchanges.moneda_id
            LEFT JOIN users ON users.id = register_details.user_id
            LEFT JOIN users as T1 ON T1.id = register_details.admin_id
            LEFT JOIN sorteos_types ON register_details.sorteo_type_id = sorteos_types.id
            WHERE (DATE(register_details.created_at) BETWEEN DATE(:fecha_inicio) AND DATE(:fecha_fin))
            and register_details.admin_id = :admin_id
            GROUP BY user_id ,register_details.moneda_id, register_details.sorteo_type_id
            ORDER BY user_id"), ['fecha_inicio' => $dt->format('Y-m-d') . ' 00:00:00', 'fecha_fin' =>  $dt2->format('Y-m-d') . ' 23:59:59',"admin_id" => auth()->user()->id]);
            }

            // dd($results);

            $results = collect($results);
            $g = $results->groupBy('taquilla_name');

            $gg = $g->map(function ($v) {
                $m = $v->groupBy('currency');
                $tm = $m->each(function ($e) {
                    $total_monto = $e->sum('monto_total');
                    $comision_total = $e->sum('comision_total');
                    $premio_total = $e->sum('premio_total');
                    $animalitos_vendidos = $e->sum('animalitos_vendidos');

                    // dd($total_monto,$comision_total,$premio_total,$animalitos_vendidos);
                    // $e-> totales = [
                    //     'total_monto' => $total_monto,
                    //     'comision_total' => $comision_total,
                    //     'premio_total' => $premio_total,
                    //     'animalitos_vendidos' => $animalitos_vendidos,
                    // ];

                    $r = collect([
                        'total_monto' => $total_monto,
                        'comision_total' => $comision_total,
                        'premio_total' => $premio_total,
                        'animalitos_vendidos' => $animalitos_vendidos,
                    ]);

                    $e->push($r);
                    return $e;
                });
                return $tm;

                // dd($tm);
                // dd($m);
                // dd($v);
                // $total = $v->sum(function($q){
                //     return $q->monto_total;
                // });
                // dd($total);

            });

            // dd($results);

            $balance_money_group = $results->groupBy('currency');

            $balance_general = $balance_money_group->each(function ($ghh) {

                $total_monto = $ghh->sum('monto_total');
                $comision_total = $ghh->sum('comision_total');
                $premio_total = $ghh->sum('premio_total');
                $animalitos_vendidos = $ghh->sum('animalitos_vendidos');


                $r2 = collect([
                    'total_monto' => $total_monto,
                    'comision_total' => $comision_total,
                    'premio_total' => $premio_total,
                    'animalitos_vendidos' => $animalitos_vendidos,
                ]);

                $ghh->push($r2);
                return $ghh;
            });


            return view('home2', compact('results', 'gg', 'balance_general'));
        }
        if (auth()->user()->role_id == 3) {

            if (!isset($data['fecha_inicio']) && !isset($data['fecha_fin'])) {
                $results = DB::select(DB::raw("SELECT user_id,register_details.moneda_id AS moneda,
                T1.name as admin_name,
                users.taquilla_name as taquilla_name,users.name,
                monedas.currency,monedas.simbolo,
                sorteos_types.name AS loteria_name,
    
                SUM(monto) AS monto_total,
                SUM(monto * (users.comision) / 100) AS comision_total,
                SUM(IF(register_details.winner = 1, (monto * sorteos_types.premio_multiplication) , 0 )) AS premio_total,
    
                SUM(monto / exchanges.change_usd ) AS usd_monto_total,
                SUM((monto * (users.comision) / 100) /  exchanges.change_usd) AS usd_comision_total,
                SUM(IF(register_details.winner = 1, (monto * sorteos_types.premio_multiplication) / exchanges.change_usd , 0 )) AS usd_premio_total,
    
                COUNT(*) AS animalitos_vendidos
                FROM register_details  
                LEFT JOIN monedas ON register_details.moneda_id = monedas.id
                LEFT JOIN exchanges ON register_details.moneda_id = exchanges.moneda_id
                LEFT JOIN users ON users.id = register_details.user_id
                LEFT JOIN users as T1 ON T1.id = register_details.admin_id
                LEFT JOIN sorteos_types ON register_details.sorteo_type_id = sorteos_types.id
                WHERE date(register_details.created_at) >= date(:fecha_inicio) 
                and register_details.user_id = :user_id
                GROUP BY user_id ,register_details.moneda_id, register_details.sorteo_type_id
                ORDER BY user_id"), ['fecha_inicio' => $dt->format('Y-m-d'), "user_id" => auth()->user()->id]);
            }



            if (isset($data['fecha_inicio']) && !isset($data['fecha_fin'])) {
                $results = DB::select(DB::raw("SELECT user_id,register_details.moneda_id AS moneda,
            T1.name as admin_name,
            users.taquilla_name,users.name,
            monedas.currency,monedas.simbolo,
            sorteos_types.name AS loteria_name,

            SUM(monto) AS monto_total,
            SUM(monto * (users.comision) / 100) AS comision_total,
            SUM(IF(register_details.winner = 1, (monto * sorteos_types.premio_multiplication) , 0 )) AS premio_total,

            SUM(monto / exchanges.change_usd ) AS usd_monto_total,
            SUM((monto * (users.comision) / 100) /  exchanges.change_usd)  AS usd_comision_total,
            SUM(IF(register_details.winner = 1, (monto * sorteos_types.premio_multiplication) / exchanges.change_usd , 0 )) AS usd_premio_total,

            COUNT(*) AS animalitos_vendidos
            FROM register_details  
            LEFT JOIN monedas ON register_details.moneda_id = monedas.id
            LEFT JOIN exchanges ON register_details.moneda_id = exchanges.moneda_id
            LEFT JOIN users ON users.id = register_details.user_id
            LEFT JOIN users as T1 ON T1.id = register_details.admin_id
            LEFT JOIN sorteos_types ON register_details.sorteo_type_id = sorteos_types.id
            WHERE date(register_details.created_at) >= date(:fecha_inicio) 
            and register_details.user_id = :user_id
            GROUP BY user_id ,register_details.moneda_id, register_details.sorteo_type_id
            ORDER BY user_id"), ['fecha_inicio' => $dt->format('Y-m-d'), "user_id" => auth()->user()->id]);

                // dd($results);
            }


            if (isset($data['fecha_inicio']) && isset($data['fecha_fin'])) {

                // dd($dt->format('Y-m-d') . ' 00:00:00', $dt2->format('Y-m-d') . ' 23:59:59');
                $results = DB::select(DB::raw("SELECT user_id,register_details.moneda_id AS moneda,
            T1.name as admin_name,
            users.taquilla_name,users.name,
            monedas.currency,monedas.simbolo,
            sorteos_types.name AS loteria_name,

            SUM(monto) AS monto_total,
            SUM(monto * (users.comision) / 100) AS comision_total,
            SUM(IF(register_details.winner = 1, (monto * sorteos_types.premio_multiplication) , 0 )) AS premio_total,

            SUM(monto / exchanges.change_usd ) AS usd_monto_total,
            SUM((monto * (users.comision) / 100) /  exchanges.change_usd)  AS usd_comision_total,
            SUM(IF(register_details.winner = 1, (monto * sorteos_types.premio_multiplication) / exchanges.change_usd , 0 )) AS usd_premio_total,

            COUNT(*) AS animalitos_vendidos
            FROM register_details  
            LEFT JOIN monedas ON register_details.moneda_id = monedas.id
            LEFT JOIN exchanges ON register_details.moneda_id = exchanges.moneda_id
            LEFT JOIN users ON users.id = register_details.user_id
            LEFT JOIN users as T1 ON T1.id = register_details.admin_id
            LEFT JOIN sorteos_types ON register_details.sorteo_type_id = sorteos_types.id
            WHERE (DATE(register_details.created_at) BETWEEN DATE(:fecha_inicio) AND DATE(:fecha_fin))
            and register_details.user_id = :user_id
            GROUP BY user_id ,register_details.moneda_id, register_details.sorteo_type_id
            ORDER BY user_id"), ['fecha_inicio' => $dt->format('Y-m-d') . ' 00:00:00', 'fecha_fin' =>  $dt2->format('Y-m-d') . ' 23:59:59',"user_id" => auth()->user()->id]);
            }

            // dd($results);

            $results = collect($results);
            $g = $results->groupBy('taquilla_name');

            $gg = $g->map(function ($v) {
                $m = $v->groupBy('currency');
                $tm = $m->each(function ($e) {
                    $total_monto = $e->sum('monto_total');
                    $comision_total = $e->sum('comision_total');
                    $premio_total = $e->sum('premio_total');
                    $animalitos_vendidos = $e->sum('animalitos_vendidos');

                    // dd($total_monto,$comision_total,$premio_total,$animalitos_vendidos);
                    // $e-> totales = [
                    //     'total_monto' => $total_monto,
                    //     'comision_total' => $comision_total,
                    //     'premio_total' => $premio_total,
                    //     'animalitos_vendidos' => $animalitos_vendidos,
                    // ];

                    $r = collect([
                        'total_monto' => $total_monto,
                        'comision_total' => $comision_total,
                        'premio_total' => $premio_total,
                        'animalitos_vendidos' => $animalitos_vendidos,
                    ]);

                    $e->push($r);
                    return $e;
                });
                return $tm;

                // dd($tm);
                // dd($m);
                // dd($v);
                // $total = $v->sum(function($q){
                //     return $q->monto_total;
                // });
                // dd($total);

            });

            // dd($results);

            $balance_money_group = $results->groupBy('currency');

            $balance_general = $balance_money_group->each(function ($ghh) {

                $total_monto = $ghh->sum('monto_total');
                $comision_total = $ghh->sum('comision_total');
                $premio_total = $ghh->sum('premio_total');
                $animalitos_vendidos = $ghh->sum('animalitos_vendidos');


                $r2 = collect([
                    'total_monto' => $total_monto,
                    'comision_total' => $comision_total,
                    'premio_total' => $premio_total,
                    'animalitos_vendidos' => $animalitos_vendidos,
                ]);

                $ghh->push($r2);
                return $ghh;
            });


            return view('home2', compact('results', 'gg', 'balance_general'));
        }
    }
}
