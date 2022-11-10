<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController2 extends Controller
{
    //
    public function index()
    {


        // dd($dt->format('Y-m-d'));
        // $results = DB::select(DB::raw("SELECT register_id, FROM register_details where DATE(created_at) = '2022-11-01' "), ['fecha' => $dt->format('Y-m-d') . ' 00:00:00']);

        # Posiblemente 
        if (false) {

            $results = DB::select(DB::raw("SELECT
                register_id,animal_id,admin_id,winner,
                monedas.currency,monedas.simbolo,
                monto AS monto_total,
                IF(winner = 1, monto * sorteos_types.premio_multiplication , 0 ) AS premio_total,
                monto * (users.comision / 100) AS comision_total,
                register_details.moneda_id,user_id,sorteo_type_id,
                        
                monto / exchanges.change_usd AS usd_venta_total,
                IF(winner = 1, (monto * sorteos_types.premio_multiplication) / exchanges.change_usd , 0 ) AS usd_premio_total,
                monto * (users.comision / 100) / exchanges.change_usd  AS usd_comision_total
                        
                FROM register_details
                LEFT JOIN monedas ON register_details.moneda_id = monedas.id
                LEFT JOIN exchanges ON register_details.moneda_id = exchanges.moneda_id
                LEFT JOIN users ON register_details.user_id = users.id  
                LEFT JOIN sorteos_types ON register_details.sorteo_type_id = sorteos_types.id
                WHERE Date(register_details.created_at) >= '2022-11-10'"));

            dd($results);
        }

    }
}
