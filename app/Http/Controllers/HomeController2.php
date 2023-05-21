<?php

namespace App\Http\Controllers;

use App\Models\User;
use DateTime;
use DateTimeZone;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController2 extends Controller
{

    public function __construct()
    {
        // $this->comision_vendedores = 0.13;
        $this->amount_rewards = 30; //numero por que se multiplica los premios
        $this->middleware('auth');
        $this->middleware('timezone');
    }
    //
    public function index(Request $request)
    {
        $admin = User::find($request->user()->parent_id);

        if (count($request->all()) > 1) {
            $data = $request->all();
            $dt = new DateTime($data['fecha_inicio'] . " 00:00:00", new DateTimeZone('America/Caracas'));
            if (isset($data['fecha_fin'])) {
                $dt2 = new DateTime($data['fecha_fin'] . " 00:00:00", new DateTimeZone('America/Caracas'));
            }
        } else {
            $dt = new DateTime(date('Y-m-d H:i:s'), new DateTimeZone('UTC'));
            $dt = $dt->setTimezone(new DateTimeZone("America/Caracas"));
        }

        if (auth()->user()->role_id == 1) {

            if (!isset($data['fecha_inicio']) && !isset($data['fecha_fin'])) {
                $results = DB::select(DB::raw("SELECT user_id,register_details.moneda_id AS moneda,
                T1.name as admin_name,
                users.taquilla_name as taquilla_name,
                users.name,
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


                $result_tripletas = DB::select(DB::raw("SELECT 
                    td.id AS tripleta_id,
                    m.id AS moneda_id,
                    m.currency,
                    m.simbolo,
                    u.id AS user_id,
                    u.parent_id AS admin_id,
                    a.name AS admin_name,
                    u.taquilla_name,
                    u.name,
                    'Tripletas' AS loteria_name,
                    SUM(td.total) AS monto_total,
                    SUM(td.total * (u.comision / 100)) AS comision_total,
                    SUM(IF(td.animal_1_has_win = 1 AND td.animal_2_has_win = 1 AND td.animal_3_has_win = 1, td.total * 50, 0)) AS premio_total,

                    0 as animal_id,
                    0 as sorteo_type_id,
                    SUM(td.total / e.change_usd) AS usd_venta_total,
                    SUM(IF(td.animal_1_has_win = 1 AND td.animal_2_has_win = 1 AND td.animal_3_has_win = 1, td.total * 50 / e.change_usd, 0)) AS premio_total_usd,
                    SUM(td.total * (u.comision / 100) / e.change_usd) AS comision_total_usd,

                    COUNT(*) AS animalitos_vendidos

                    FROM 
                    tripleta_details as td
                    LEFT JOIN tripletas t ON td.tripleta_id = t.id
                    LEFT JOIN monedas m ON t.moneda_id = m.id
                    LEFT JOIN exchanges e ON t.moneda_id = e.moneda_id
                    LEFT JOIN users u ON t.user_id = u.id
                    LEFT JOIN users a ON a.id = u.parent_id

                    WHERE DATE(td.created_at) >= DATE(:fecha_inicio) 
                    and t.status != 0
                    GROUP BY u.id ,m.id, sorteo_type_id
                    ORDER BY u.id
                    "), ['fecha_inicio' => $dt->format('Y-m-d')]);

                // dd($result_tripletas);
                $results = array_merge($results, $result_tripletas);
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

                $result_tripletas = DB::select(DB::raw("SELECT 
                    td.id AS tripleta_id,
                    m.id AS moneda_id,
                    m.currency,
                    m.simbolo,
                    u.id AS user_id,
                    u.parent_id AS admin_id,
                    a.name AS admin_name,
                    u.taquilla_name,
                    u.name,
                    'Tripletas' AS loteria_name,
                    SUM(td.total) AS monto_total,
                    SUM(td.total * (u.comision / 100)) AS comision_total,
                    SUM(IF(td.animal_1_has_win = 1 AND td.animal_2_has_win = 1 AND td.animal_3_has_win = 1, td.total * 50, 0)) AS premio_total,

                    0 as animal_id,
                    0 as sorteo_type_id,
                    SUM(td.total / e.change_usd) AS usd_venta_total,
                    SUM(IF(td.animal_1_has_win = 1 AND td.animal_2_has_win = 1 AND td.animal_3_has_win = 1, td.total * 50 / e.change_usd, 0)) AS premio_total_usd,
                    SUM(td.total * (u.comision / 100) / e.change_usd) AS comision_total_usd,

                    COUNT(*) AS animalitos_vendidos

                    FROM 
                    tripleta_details as td
                    LEFT JOIN tripletas t ON td.tripleta_id = t.id
                    LEFT JOIN monedas m ON t.moneda_id = m.id
                    LEFT JOIN exchanges e ON t.moneda_id = e.moneda_id
                    LEFT JOIN users u ON t.user_id = u.id
                    LEFT JOIN users a ON a.id = u.parent_id

                    WHERE DATE(td.created_at) >= DATE(:fecha_inicio) 
                    and t.status != 0
                    GROUP BY u.id ,m.id, sorteo_type_id
                    ORDER BY u.id
                    "), ['fecha_inicio' => $dt->format('Y-m-d')]);

                // dd($result_tripletas);
                $results = array_merge($results, $result_tripletas);
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


                $result_tripletas = DB::select(DB::raw("SELECT 
                td.id AS tripleta_id,
                m.id AS moneda_id,
                m.currency,
                m.simbolo,
                u.id AS user_id,
                u.parent_id AS admin_id,
                a.name AS admin_name,
                u.taquilla_name,
                u.name,
                'Tripletas' AS loteria_name,
                SUM(td.total) AS monto_total,
                SUM(td.total * (u.comision / 100)) AS comision_total,
                SUM(IF(td.animal_1_has_win = 1 AND td.animal_2_has_win = 1 AND td.animal_3_has_win = 1, td.total * 50, 0)) AS premio_total,

                0 as animal_id,
                0 as sorteo_type_id,
                SUM(td.total / e.change_usd) AS usd_venta_total,
                SUM(IF(td.animal_1_has_win = 1 AND td.animal_2_has_win = 1 AND td.animal_3_has_win = 1, td.total * 50 / e.change_usd, 0)) AS premio_total_usd,
                SUM(td.total * (u.comision / 100) / e.change_usd) AS comision_total_usd,

                COUNT(*) AS animalitos_vendidos

                FROM 
                tripleta_details as td
                LEFT JOIN tripletas t ON td.tripleta_id = t.id
                LEFT JOIN monedas m ON t.moneda_id = m.id
                LEFT JOIN exchanges e ON t.moneda_id = e.moneda_id
                LEFT JOIN users u ON t.user_id = u.id
                LEFT JOIN users a ON a.id = u.parent_id
                WHERE (DATE(td.created_at) BETWEEN DATE(:fecha_inicio) AND DATE(:fecha_fin))
                and t.status != 0
                GROUP BY u.id ,m.id, sorteo_type_id
                ORDER BY u.id
                "), ['fecha_inicio' => $dt->format('Y-m-d') . ' 00:00:00', 'fecha_fin' =>  $dt2->format('Y-m-d') . ' 23:59:59']);

                // dd($result_tripletas);
                $results = array_merge($results, $result_tripletas);
            }

            $results = collect($results);
            $g = $results->groupBy('admin_name');



            // dd($loterias);
            $gg = $g->map(function ($v) {
                $m = $v->groupBy('currency');
                $tm = $m->each(function ($e) {
                    $total_monto = $e->sum('monto_total');
                    $comision_total = $e->sum('comision_total');
                    $premio_total = $e->sum('premio_total');
                    $animalitos_vendidos = $e->sum('animalitos_vendidos');

                    $r = collect([
                        'total_monto' => $total_monto,
                        'comision_total' => $comision_total,
                        'premio_total' => $premio_total,

                    ]);

                    $e->push($r);
                    return $e;
                });
                return $tm;
            });

            $loterias = $results->groupBy('loteria_name');
            $loteria_balance = $loterias->map(function ($v) {
                $m = $v->groupBy('currency');
                $tm = $m->each(function ($e) {
                    $total_monto = $e->sum('monto_total');
                    $comision_total = $e->sum('comision_total');
                    $premio_total = $e->sum('premio_total');
                    $animalitos_vendidos = $e->sum('animalitos_vendidos');

                    $r = collect([
                        'total_monto' => $total_monto,
                        'comision_total' => $comision_total,
                        'premio_total' => $premio_total,
                    ]);
                    $e->push($r);
                    return $e;
                });
                return $tm;
            });

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
                ]);

                $ghh->push($r2);
                return $ghh;
            });


            return view('home2', compact('results', 'gg', 'balance_general', 'loteria_balance', 'admin'));
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

                $result_tripletas = DB::select(DB::raw("SELECT 
                td.id AS tripleta_id,
                m.id AS moneda_id,
                m.currency,
                m.simbolo,
                u.id AS user_id,
                u.parent_id AS admin_id,
                a.name AS admin_name,
                u.taquilla_name,
                u.name,
                'Tripletas' AS loteria_name,
                SUM(td.total) AS monto_total,
                SUM(td.total * (u.comision / 100)) AS comision_total,
                SUM(IF(td.animal_1_has_win = 1 AND td.animal_2_has_win = 1 AND td.animal_3_has_win = 1, td.total * 50, 0)) AS premio_total,

                0 as animal_id,
                0 as sorteo_type_id,
                SUM(td.total / e.change_usd) AS usd_venta_total,
                SUM(IF(td.animal_1_has_win = 1 AND td.animal_2_has_win = 1 AND td.animal_3_has_win = 1, td.total * 50 / e.change_usd, 0)) AS premio_total_usd,
                SUM(td.total * (u.comision / 100) / e.change_usd) AS comision_total_usd,

                COUNT(*) AS animalitos_vendidos

                FROM 
                tripleta_details as td
                LEFT JOIN tripletas t ON td.tripleta_id = t.id
                LEFT JOIN monedas m ON t.moneda_id = m.id
                LEFT JOIN exchanges e ON t.moneda_id = e.moneda_id
                LEFT JOIN users u ON t.user_id = u.id
                LEFT JOIN users a ON a.id = u.parent_id

                WHERE DATE(td.created_at) >= DATE(:fecha_inicio) 
                and t.status != 0 and t.admin_id = :admin_id
                GROUP BY u.id ,m.id, sorteo_type_id
                ORDER BY u.id "), ['fecha_inicio' => $dt->format('Y-m-d'), "admin_id" => auth()->user()->id]);
                $results = array_merge($results, $result_tripletas);
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

                $result_tripletas = DB::select(DB::raw("SELECT 
                td.id AS tripleta_id,
                m.id AS moneda_id,
                m.currency,
                m.simbolo,
                u.id AS user_id,
                u.parent_id AS admin_id,
                a.name AS admin_name,
                u.taquilla_name,
                u.name,
                'Tripletas' AS loteria_name,
                SUM(td.total) AS monto_total,
                SUM(td.total * (u.comision / 100)) AS comision_total,
                SUM(IF(td.animal_1_has_win = 1 AND td.animal_2_has_win = 1 AND td.animal_3_has_win = 1, td.total * 50, 0)) AS premio_total,

                0 as animal_id,
                0 as sorteo_type_id,
                SUM(td.total / e.change_usd) AS usd_venta_total,
                SUM(IF(td.animal_1_has_win = 1 AND td.animal_2_has_win = 1 AND td.animal_3_has_win = 1, td.total * 50 / e.change_usd, 0)) AS premio_total_usd,
                SUM(td.total * (u.comision / 100) / e.change_usd) AS comision_total_usd,

                COUNT(*) AS animalitos_vendidos

                FROM 
                tripleta_details as td
                LEFT JOIN tripletas t ON td.tripleta_id = t.id
                LEFT JOIN monedas m ON t.moneda_id = m.id
                LEFT JOIN exchanges e ON t.moneda_id = e.moneda_id
                LEFT JOIN users u ON t.user_id = u.id
                LEFT JOIN users a ON a.id = u.parent_id

                WHERE DATE(td.created_at) >= DATE(:fecha_inicio) 
                and t.status != 0 and t.admin_id = :admin_id
                GROUP BY u.id ,m.id, sorteo_type_id
                ORDER BY u.id "), ['fecha_inicio' => $dt->format('Y-m-d'), "admin_id" => auth()->user()->id]);
                $results = array_merge($results, $result_tripletas);
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
                ORDER BY user_id"), ['fecha_inicio' => $dt->format('Y-m-d') . ' 00:00:00', 'fecha_fin' =>  $dt2->format('Y-m-d') . ' 23:59:59', "admin_id" => auth()->user()->id]);


                $result_tripletas = DB::select(DB::raw("SELECT 
                td.id AS tripleta_id,
                m.id AS moneda_id,
                m.currency,
                m.simbolo,
                u.id AS user_id,
                u.parent_id AS admin_id,
                a.name AS admin_name,
                u.taquilla_name,
                u.name,
                'Tripletas' AS loteria_name,
                SUM(td.total) AS monto_total,
                SUM(td.total * (u.comision / 100)) AS comision_total,
                SUM(IF(td.animal_1_has_win = 1 AND td.animal_2_has_win = 1 AND td.animal_3_has_win = 1, td.total * 50, 0)) AS premio_total,

                0 as animal_id,
                0 as sorteo_type_id,
                SUM(td.total / e.change_usd) AS usd_venta_total,
                SUM(IF(td.animal_1_has_win = 1 AND td.animal_2_has_win = 1 AND td.animal_3_has_win = 1, td.total * 50 / e.change_usd, 0)) AS premio_total_usd,
                SUM(td.total * (u.comision / 100) / e.change_usd) AS comision_total_usd,

                COUNT(*) AS animalitos_vendidos

                FROM 
                tripleta_details as td
                LEFT JOIN tripletas t ON td.tripleta_id = t.id
                LEFT JOIN monedas m ON t.moneda_id = m.id
                LEFT JOIN exchanges e ON t.moneda_id = e.moneda_id
                LEFT JOIN users u ON t.user_id = u.id
                LEFT JOIN users a ON a.id = u.parent_id

                WHERE (DATE(td.created_at) BETWEEN DATE(:fecha_inicio) AND DATE(:fecha_fin))
                and t.status != 0 
                and t.admin_id = :admin_id
                GROUP BY u.id ,m.id, sorteo_type_id
                ORDER BY u.id "), ['fecha_inicio' => $dt->format('Y-m-d') . ' 00:00:00', 'fecha_fin' =>  $dt2->format('Y-m-d') . ' 23:59:59', "admin_id" => auth()->user()->id]);
                $results = array_merge($results, $result_tripletas);
            }


            $results = collect($results);
            $g = $results->groupBy('taquilla_name');

            $gg = $g->map(function ($v) {
                $m = $v->groupBy('currency');
                $tm = $m->each(function ($e) {
                    $total_monto = $e->sum('monto_total');
                    $comision_total = $e->sum('comision_total');
                    $premio_total = $e->sum('premio_total');
                    $animalitos_vendidos = $e->sum('animalitos_vendidos');

                    $r = collect([
                        'total_monto' => $total_monto,
                        'comision_total' => $comision_total,
                        'premio_total' => $premio_total,

                    ]);

                    $e->push($r);
                    return $e;
                });
                return $tm;
            });




            $loterias = $results->groupBy('loteria_name');
            $loteria_balance = $loterias->map(function ($v) {
                $m = $v->groupBy('currency');
                $tm = $m->each(function ($e) {
                    $total_monto = $e->sum('monto_total');
                    $comision_total = $e->sum('comision_total');
                    $premio_total = $e->sum('premio_total');
                    $animalitos_vendidos = $e->sum('animalitos_vendidos');



                    $r = collect([
                        'total_monto' => $total_monto,
                        'comision_total' => $comision_total,
                        'premio_total' => $premio_total,

                    ]);

                    $e->push($r);
                    return $e;
                });
                return $tm;
            });


            $loterias = $results->groupBy('loteria_name');
            $loteria_balance = $loterias->map(function ($v) {
                $m = $v->groupBy('currency');
                $tm = $m->each(function ($e) {
                    $total_monto = $e->sum('monto_total');
                    $comision_total = $e->sum('comision_total');
                    $premio_total = $e->sum('premio_total');
                    $animalitos_vendidos = $e->sum('animalitos_vendidos');

                    $r = collect([
                        'total_monto' => $total_monto,
                        'comision_total' => $comision_total,
                        'premio_total' => $premio_total,
                    ]);

                    $e->push($r);
                    return $e;
                });
                return $tm;
            });

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

                ]);

                $ghh->push($r2);
                return $ghh;
            });

            return view('home2', compact('results', 'gg', 'balance_general', 'loteria_balance', 'admin'));
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

                $result_tripletas = DB::select(DB::raw("SELECT 
                td.id AS tripleta_id,
                m.id AS moneda_id,
                m.currency,
                m.simbolo,
                u.id AS user_id,
                u.parent_id AS admin_id,
                a.name AS admin_name,
                u.taquilla_name,
                u.name,
                'Tripletas' AS loteria_name,
                SUM(td.total) AS monto_total,
                SUM(td.total * (u.comision / 100)) AS comision_total,
                SUM(IF(td.animal_1_has_win = 1 AND td.animal_2_has_win = 1 AND td.animal_3_has_win = 1, td.total * 50, 0)) AS premio_total,

                0 as animal_id,
                0 as sorteo_type_id,
                SUM(td.total / e.change_usd) AS usd_venta_total,
                SUM(IF(td.animal_1_has_win = 1 AND td.animal_2_has_win = 1 AND td.animal_3_has_win = 1, td.total * 50 / e.change_usd, 0)) AS premio_total_usd,
                SUM(td.total * (u.comision / 100) / e.change_usd) AS comision_total_usd,

                COUNT(*) AS animalitos_vendidos

                FROM 
                tripleta_details as td
                LEFT JOIN tripletas t ON td.tripleta_id = t.id
                LEFT JOIN monedas m ON t.moneda_id = m.id
                LEFT JOIN exchanges e ON t.moneda_id = e.moneda_id
                LEFT JOIN users u ON t.user_id = u.id
                LEFT JOIN users a ON a.id = u.parent_id

                WHERE DATE(td.created_at) >= DATE(:fecha_inicio) 
                and t.status != 0 
                and t.user_id = :user_id
                GROUP BY u.id, m.id, sorteo_type_id
                ORDER BY u.id
                "), ['fecha_inicio' => $dt->format('Y-m-d'), "user_id" => auth()->user()->id]);
                $results = array_merge($results, $result_tripletas);
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

                $result_tripletas = DB::select(DB::raw("SELECT 
                td.id AS tripleta_id,
                m.id AS moneda_id,
                m.currency,
                m.simbolo,
                u.id AS user_id,
                u.parent_id AS admin_id,
                a.name AS admin_name,
                u.taquilla_name,
                u.name,
                'Tripletas' AS loteria_name,
                SUM(td.total) AS monto_total,
                SUM(td.total * (u.comision / 100)) AS comision_total,
                SUM(IF(td.animal_1_has_win = 1 AND td.animal_2_has_win = 1 AND td.animal_3_has_win = 1, td.total * 50, 0)) AS premio_total,

                0 as animal_id,
                0 as sorteo_type_id,
                SUM(td.total / e.change_usd) AS usd_venta_total,
                SUM(IF(td.animal_1_has_win = 1 AND td.animal_2_has_win = 1 AND td.animal_3_has_win = 1, td.total * 50 / e.change_usd, 0)) AS premio_total_usd,
                SUM(td.total * (u.comision / 100) / e.change_usd) AS comision_total_usd,

                COUNT(*) AS animalitos_vendidos

                FROM 
                tripleta_details as td
                LEFT JOIN tripletas t ON td.tripleta_id = t.id
                LEFT JOIN monedas m ON t.moneda_id = m.id
                LEFT JOIN exchanges e ON t.moneda_id = e.moneda_id
                LEFT JOIN users u ON t.user_id = u.id
                LEFT JOIN users a ON a.id = u.parent_id

                WHERE DATE(td.created_at) >= DATE(:fecha_inicio) 
                and t.status != 0 
                and t.user_id = :user_id
                GROUP BY u.id, m.id, sorteo_type_id
                ORDER BY u.id "), ['fecha_inicio' => $dt->format('Y-m-d'), "user_id" => auth()->user()->id]);
                $results = array_merge($results, $result_tripletas);
            }


            if (isset($data['fecha_inicio']) && isset($data['fecha_fin'])) {

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
                ORDER BY user_id"), ['fecha_inicio' => $dt->format('Y-m-d') . ' 00:00:00', 'fecha_fin' =>  $dt2->format('Y-m-d') . ' 23:59:59', "user_id" => auth()->user()->id]);


                $result_tripletas = DB::select(DB::raw("SELECT 
                td.id AS tripleta_id,
                m.id AS moneda_id,
                m.currency,
                m.simbolo,
                u.id AS user_id,
                u.parent_id AS admin_id,
                a.name AS admin_name,
                u.taquilla_name,
                u.name,
                'Tripletas' AS loteria_name,
                SUM(td.total) AS monto_total,
                SUM(td.total * (u.comision / 100)) AS comision_total,
                SUM(IF(td.animal_1_has_win = 1 AND td.animal_2_has_win = 1 AND td.animal_3_has_win = 1, td.total * 50, 0)) AS premio_total,

                0 as animal_id,
                0 as sorteo_type_id,
                SUM(td.total / e.change_usd) AS usd_venta_total,
                SUM(IF(td.animal_1_has_win = 1 AND td.animal_2_has_win = 1 AND td.animal_3_has_win = 1, td.total * 50 / e.change_usd, 0)) AS premio_total_usd,
                SUM(td.total * (u.comision / 100) / e.change_usd) AS comision_total_usd,

                COUNT(*) AS animalitos_vendidos

                FROM 
                tripleta_details as td
                LEFT JOIN tripletas t ON td.tripleta_id = t.id
                LEFT JOIN monedas m ON t.moneda_id = m.id
                LEFT JOIN exchanges e ON t.moneda_id = e.moneda_id
                LEFT JOIN users u ON t.user_id = u.id
                LEFT JOIN users a ON a.id = u.parent_id

                WHERE (DATE(td.created_at) BETWEEN DATE(:fecha_inicio) AND DATE(:fecha_fin))
                and t.user_id = :user_id
                GROUP BY u.id, m.id, sorteo_type_id
                "), ['fecha_inicio' => $dt->format('Y-m-d') . ' 00:00:00', 'fecha_fin' =>  $dt2->format('Y-m-d') . ' 23:59:59', "user_id" => auth()->user()->id]);

                $results = array_merge($results, $result_tripletas);
            }



            $results = collect($results);
            $g = $results->groupBy('taquilla_name');

            $gg = $g->map(function ($v) {
                $m = $v->groupBy('currency');
                $tm = $m->each(function ($e) {
                    $total_monto = $e->sum('monto_total');
                    $comision_total = $e->sum('comision_total');
                    $premio_total = $e->sum('premio_total');
                    $animalitos_vendidos = $e->sum('animalitos_vendidos');



                    $r = collect([
                        'total_monto' => $total_monto,
                        'comision_total' => $comision_total,
                        'premio_total' => $premio_total,

                    ]);

                    $e->push($r);
                    return $e;
                });
                return $tm;
            });



            $loterias = $results->groupBy('loteria_name');
            $loteria_balance = $loterias->map(function ($v) {
                $m = $v->groupBy('currency');
                $tm = $m->each(function ($e) {
                    $total_monto = $e->sum('monto_total');
                    $comision_total = $e->sum('comision_total');
                    $premio_total = $e->sum('premio_total');
                    $animalitos_vendidos = $e->sum('animalitos_vendidos');

                    $r = collect([
                        'total_monto' => $total_monto,
                        'comision_total' => $comision_total,
                        'premio_total' => $premio_total,

                    ]);

                    $e->push($r);
                    return $e;
                });
                return $tm;
            });

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
                    //'animalitos_vendidos' => $animalitos_vendidos,
                ]);

                $ghh->push($r2);
                return $ghh;
            });


            return view('home2', compact('results', 'gg', 'balance_general', 'loteria_balance', 'admin'));
        }
    }
}
