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
            $dt = new DateTime($data['fecha_inicio'] . " 00:00:00", new DateTimeZone('UTC'));
            if (isset($data['fecha_fin'])) {
                $dt2 = new DateTime($data['fecha_fin'] . " 00:00:00", new DateTimeZone('UTC'));
                // $dt2->setTimezone(new DateTimeZone(session('timezone')));
            }
        } else {
            $dt = new DateTime(date('Y-m-d H:i:s'), new DateTimeZone('UTC'));
            // $dt->setTimezone(new DateTimeZone(session('timezone')));
        }

        // dd($dt->format('Y-m-d'));

        if (auth()->user()->role_id == 1) {

            if (!isset($data['fecha_inicio']) && !isset($data['fecha_fin'])) {
                $results = DB::select(DB::raw("SELECT user_id,register_details.moneda_id AS moneda,
                users.taquilla_name as taquilla_name,users.name,
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
                LEFT JOIN sorteos_types ON register_details.sorteo_type_id = sorteos_types.id
                WHERE date(register_details.created_at) >= date(:fecha_inicio)   
                GROUP BY user_id ,register_details.moneda_id, register_details.sorteo_type_id
                ORDER BY user_id"), ['fecha_inicio' => $dt->format('Y-m-d')]);
            }



            if (isset($data['fecha_inicio']) && !isset($data['fecha_fin'])) {
                $results = DB::select(DB::raw("SELECT user_id,register_details.moneda_id AS moneda,
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
            LEFT JOIN sorteos_types ON register_details.sorteo_type_id = sorteos_types.id
            WHERE date(register_details.created_at) >= date(:fecha_inicio)   
            GROUP BY user_id ,register_details.moneda_id, register_details.sorteo_type_id
            ORDER BY user_id"), ['fecha_inicio' => $dt->format('Y-m-d')]);

                // dd($results);
            }


            if (isset($data['fecha_inicio']) && isset($data['fecha_fin'])) {

                // dd($dt->format('Y-m-d') . ' 00:00:00', $dt2->format('Y-m-d') . ' 23:59:59');
                $results = DB::select(DB::raw("SELECT user_id,register_details.moneda_id AS moneda,
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
            LEFT JOIN sorteos_types ON register_details.sorteo_type_id = sorteos_types.id
            WHERE (DATE(register_details.created_at) BETWEEN DATE(:fecha_inicio) AND DATE(:fecha_fin))
            GROUP BY user_id ,register_details.moneda_id, register_details.sorteo_type_id
            ORDER BY user_id"), ['fecha_inicio' => $dt->format('Y-m-d') . ' 00:00:00', 'fecha_fin' =>  $dt2->format('Y-m-d') . ' 23:59:59']);
            }

            return view('home2', compact('results'));
        }
    }
}
