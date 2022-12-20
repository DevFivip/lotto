<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\SorteosType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JugadasController extends Controller
{
    //
    public function plays(Request $req)
    {

        try {

            $data = $req->all();

            $loteria_id = $data['loteria_id'];
            $created_at = $data['created_at'];

            $jugadas = DB::select("SELECT schedule_id as horario_id, schedule, count(*) as jugadas,
        SUM(monto) AS monto_total ,
        SUM(IF(register_details.winner = 1, (monto * sorteos_types.premio_multiplication) , 0 )) AS premio_total ,
        (SELECT sum(monto) as max_riesgo FROM `register_details` where schedule_id = horario_id and DATE(created_at) = DATE(?) GROUP BY animal_id ORDER by max_riesgo DESC Limit 1) * sorteos_types.premio_multiplication as max_riesgo,
        (SELECT sum(monto) as max_riesgo FROM `register_details` where schedule_id = horario_id and DATE(created_at) = DATE(?) GROUP BY animal_id ORDER by max_riesgo ASC Limit 1) * sorteos_types.premio_multiplication as min_riesgo
        FROM register_details
        
        LEFT JOIN sorteos_types ON register_details.sorteo_type_id = sorteos_types.id
        
        WHERE DATE(register_details.created_at) = DATE(?)
        and sorteo_type_id = ?
        and register_details.moneda_id = 1
        
        GROUP BY horario_id", [$created_at, $created_at, $created_at, $loteria_id]);

            $coll = new Collection($jugadas);
            $jugadas = $coll->pluck('jugadas')->toArray();
            $monto_total = $coll->pluck('monto_total')->toArray();
            $premio_total = $coll->pluck('premio_total')->toArray();
            $schedule = $coll->pluck('schedule')->toArray();
            $max_riesgo = $coll->pluck('max_riesgo')->toArray();
            $min_riesgo = $coll->pluck('min_riesgo')->toArray();

            // dd($jugadas, $monto_total, $premio_total,$schedule);

            $loteria = SorteosType::find($loteria_id);
            $loteria_name = $loteria->name;
            $top = false;

            return view('plays.chart', compact('jugadas', 'monto_total', 'premio_total', 'schedule', 'max_riesgo', 'min_riesgo', 'loteria_name', 'loteria_id', 'created_at', 'top'));
        } catch (\Throwable $th) {
            return redirect('/choose')->withErrors('⚠️' . $th->getMessage());
        }
    }

    public function choose()
    {
        $loterias = SorteosType::where('status', 1)->get();
        return view('plays.index', compact('loterias'));
    }

    public function detail(Request $request)
    {

        try {
            $data = $request->all();

            $loteria_id = $data['loteria_id'];
            $created_at = $data['created_at'];
            $schedule = $data['schedule'];
            $horario = Schedule::where('schedule', $schedule)->where('sorteo_type_id', $loteria_id)->first();

            $jugadas = DB::select("SELECT schedule_id as horario_id, schedule, count(*) as jugadas,
        SUM(monto) AS monto_total,
        SUM(IF(register_details.winner = 1, (monto * sorteos_types.premio_multiplication) , 0 )) AS premio_total ,
        (SELECT sum(monto) as max_riesgo FROM `register_details` where schedule_id = horario_id and DATE(created_at) = DATE(?) GROUP BY animal_id ORDER by max_riesgo DESC Limit 1) * sorteos_types.premio_multiplication as max_riesgo,
        (SELECT sum(monto) as max_riesgo FROM `register_details` where schedule_id = horario_id and DATE(created_at) = DATE(?) GROUP BY animal_id ORDER by max_riesgo ASC Limit 1) * sorteos_types.premio_multiplication as min_riesgo,
        DATE_FORMAT(from_unixtime(unix_timestamp(register_details.created_at) - unix_timestamp(register_details.created_at) mod 80), '%Y-%m-%d %H:%i:00') as createdAt 
        FROM register_details
        LEFT JOIN sorteos_types ON register_details.sorteo_type_id = sorteos_types.id
        WHERE DATE(register_details.created_at) = DATE(?)
        and sorteo_type_id = ?
        and schedule = ?
        and register_details.moneda_id = 1
        group by createdAt", [$created_at, $created_at, $created_at, $loteria_id, $schedule]);


            $coll = new Collection($jugadas);
            $jugadas = $coll->pluck('jugadas')->toArray();
            $monto_total = $coll->pluck('monto_total')->toArray();
            $premio_total = $coll->pluck('premio_total')->toArray();
            $schedule = $coll->pluck('createdAt')->toArray();
            $max_riesgo = $coll->pluck('max_riesgo')->toArray();
            $min_riesgo = $coll->pluck('min_riesgo')->toArray();

            // dd($jugadas, $monto_total, $premio_total,$schedule);

            $loteria = SorteosType::find($loteria_id);
            $loteria_name = $loteria->name;


            $loteria = SorteosType::find($loteria_id);
            $loteria_name = $loteria->name;

            $top = DB::select("SELECT animal_id,
            animals.nombre,number,
            COUNT(*) cantidad,
            SUM(monto) as monto_bs,
            SUM(monto / exchanges.change_usd) as monto_usd
            
            FROM register_details
            
            LEFT JOIN exchanges ON register_details.moneda_id = exchanges.id
            LEFT JOIN animals ON register_details.animal_id = animals.id
            
            
            WHERE DATE(register_details.created_at) = DATE(?)
            and register_details.schedule_id = ?
            and register_details.moneda_id = 1
            
            GROUP BY animal_id
            order by monto_usd DESC", [$created_at, $horario->id]);

            return view('plays.chart', compact('jugadas', 'monto_total', 'premio_total', 'schedule', 'max_riesgo', 'min_riesgo', 'loteria_name', 'loteria_id', 'created_at', 'top'));
        } catch (\Throwable $th) {
            return redirect('/choose')->withErrors('⚠️' . $th->getMessage());
        }
    }
}
