<?php

namespace App\Http\Controllers;

use App\Http\Libs\Telegram;
use App\Models\Animal;
use App\Models\Exchange;
use App\Models\Moneda;
use App\Models\Register;
use App\Models\RegisterDetail;
use App\Models\Result;
use App\Models\Schedule;
use App\Models\SorteosType;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ResultController extends Controller
{
    public $dt = 0;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('timezone');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dt = new DateTime(date('Y-m-d H:i:s'), new DateTimeZone('UTC'));
        $dt->setTimezone(new DateTimeZone(session('timezone')));
        $results = Result::with('type')->where('created_at', '>=', $dt->format('Y-m-d') . ' 00:00:00')->get();
        $results = $results->groupBy('sorteo_type_id');
        // dd($results);
        return view('results.index', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $animalitos = Animal::with('type')->get();
        $schedules = Schedule::with('type')->get();
        $sorteo_types = SorteosType::all();

        // dd($schedules[0]);

        // dd($animalitos);
        return view('results.create', compact('animalitos', 'schedules', 'sorteo_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $dt2 = new DateTime(date('Y-m-d H:i:s'), new DateTimeZone('UTC'));
        $dt = $dt2->setTimezone(new DateTimeZone("America/Caracas"));

        $data = $request->all();
        $schedule_id = $data['schedule_id'];
        $animal_number = $data['animal_id'];
        $sorteo_type_id = $data['sorteo_type_id'];

        // dd($data);

        $animal = Animal::where('sorteo_type_id', $sorteo_type_id)->where('number', $animal_number)->first();

        $old = Result::orderBy('id', 'DESC')->first();

        if ($old->schedule_id == $schedule_id && $old->animal_id == $animal->id) {
            return redirect('/resultados')->withErrors('ALERTA! Registros Similares, no se pueden guardar los resultados');
        }

        $r =  Result::create([
            'schedule_id' => $schedule_id,
            'animal_id' => $animal->id,
            "sorteo_type_id" => $sorteo_type_id,
        ]);

        $totalMonedas = Moneda::all()->toArray();
        $change = Exchange::all()->toArray();

        $reward_porcent = 0;

        switch ($sorteo_type_id) {
            case 1:
                $reward_porcent = 30;
                break;

            case 4:
                $reward_porcent = 32;
                break;

            default:
                $reward_porcent = 30;
                break;
        }

        $amount_winners = 0;
        $amount_home_usd = 0;

        if ($r) {

            $all_registers = RegisterDetail::where('winner', 0)->where("sorteo_type_id", $sorteo_type_id)->where('schedule_id', $schedule_id)->whereDate("created_at", "=", $dt->format('Y-m-d'))->get();
            $registers = RegisterDetail::where('winner', 0)->where('schedule_id', $schedule_id)->where('animal_id', $animal->id)->where('sorteo_type_id', $sorteo_type_id)->whereDate("created_at", "=", $dt->format('Y-m-d'))->get();

            foreach ($registers as $register) {
                $register->winner = 1;
                $register->update();

                //calcular el monto en dolares de los premios

                // $key =  array_search($register->moneda_id, array_column($totalMonedas, 'id'));
                $key2 =  array_search($register->moneda_id, array_column($change, 'moneda_id'));

                $amount_winners += ($register->monto * $reward_porcent) / $change[$key2]['change_usd'];

                $reg = Register::find($register->register_id);
                $reg->has_winner = 1;
                $reg->update();
            }

            $registers_losers = RegisterDetail::where('winner', 0)->where('schedule_id', $schedule_id)->where('animal_id', '!=', $animal->id)->where('sorteo_type_id', $sorteo_type_id)->whereDate("created_at", "=", $dt->format('Y-m-d'))->get();

            foreach ($registers_losers as $register_loser) {
                $register_loser->winner = -1;
                $register_loser->update();

                // $key =  array_search($register_loser->moneda_id, array_column($totalMonedas, 'id'));
                $key4 =  array_search($register_loser->moneda_id, array_column($change, 'moneda_id'));

                $amount_home_usd += $register_loser->monto / $change[$key4]['change_usd'];
                // $reg = Register::find($register->register_id);
                // $reg->has_winner = -1;
                // $reg->update();
            }



            $st = $r->update([
                'quantity_plays' => $all_registers->count(),
                'quantity_winners' => $registers->count(),
                'quantity_lossers' => $registers_losers->count(),
                'amount_winners_usd' => $amount_winners,
                'amount_home_usd' => $amount_home_usd,
                'amount_balance_usd' => $amount_home_usd - $amount_winners,
            ]);

            return redirect('/resultados')->withErrors('Resultados guardados, Cantidad de Jugadas Registradas ' . $all_registers->count() . ' ,cantidad de Ganadores ' . $registers->count() . ' Cantidad de Perdedores ' . $registers_losers->count());
        }
    }

    public static function storeDirectLottoPlus($animal_number, $schedule_id)
    {

        $dt2 = new DateTime(date('Y-m-d H:i:s'), new DateTimeZone('UTC'));
        $dt = $dt2->setTimezone(new DateTimeZone("America/Caracas"));

        $animal = Animal::where('sorteo_type_id', 4)->where('number', $animal_number)->first();
        $old = Result::where('sorteo_type_id', 4)->orderBy('id', 'DESC')->first();


        if (!!$old) {
            if ($old->schedule_id == $schedule_id && $old->animal_id == $animal->id) {
                return ['valid' => false, 'message' => 'ALERTA! Registros Similares, no se pueden guardar los resultados'];
            }
        }

        $r =  Result::create([
            'schedule_id' => $schedule_id,
            'animal_id' => $animal->id,
            'sorteo_type_id' => 4,
        ]);

        $totalMonedas = Moneda::all()->toArray();
        $change = Exchange::all()->toArray();

        // dd($data);

        $amount_winners = 0;
        $amount_home_usd = 0;

        if ($r) {

            $all_registers = RegisterDetail::where('sorteo_type_id', 4)->where('winner', 0)->where('schedule_id', $schedule_id)->whereDate("created_at", "=", $dt->format('Y-m-d'))->get();
            $registers = RegisterDetail::where('sorteo_type_id', 4)->where('winner', 0)->where('schedule_id', $schedule_id)->where('animal_id', $animal->id)->whereDate("created_at", "=", $dt->format('Y-m-d'))->get();

            // dd(date('Y-m-d'), $registers);

            foreach ($registers as $register) {
                $register->winner = 1;
                $register->update();

                //calcular el monto en dolares de los premios



                // $key =  array_search($register->moneda_id, array_column($totalMonedas, 'id'));
                $key2 =  array_search($register->moneda_id, array_column($change, 'moneda_id'));


                $amount_winners += ($register->monto * 32) / $change[$key2]['change_usd'];

                $reg = Register::find($register->register_id);
                $reg->has_winner = 1;
                $reg->update();
            }

            $registers_losers = RegisterDetail::where('sorteo_type_id', 4)->where('winner', 0)->where('schedule_id', $schedule_id)->where('animal_id', '!=', $animal->id)->whereDate("created_at", "=", $dt->format('Y-m-d'))->get();

            foreach ($registers_losers as $register_loser) {
                $register_loser->winner = -1;
                $register_loser->update();


                // $key =  array_search($register_loser->moneda_id, array_column($totalMonedas, 'id'));
                $key4 =  array_search($register_loser->moneda_id, array_column($change, 'moneda_id'));

                $amount_home_usd += $register_loser->monto / $change[$key4]['change_usd'];
                // $reg = Register::find($register->register_id);
                // $reg->has_winner = -1;
                // $reg->update();
            }

            $st = $r->update([
                'quantity_plays' => $all_registers->count(),
                'quantity_winners' => $registers->count(),
                'quantity_lossers' => $registers_losers->count(),
                'amount_winners_usd' => $amount_winners,
                'amount_home_usd' => $amount_home_usd,
                'amount_balance_usd' => $amount_home_usd - $amount_winners,
            ]);

            //eliminar si el nuevo  el igual al anterior pero sin cantidades
            // $old =  Result::find($st->id - 1);
            // if (
            //     $old->animal_id === $st->animal_id
            //     && $old->schedule === $st->schedule
            //     && $all_registers->count() == 0
            //     &&  $registers->count()
            //     && $registers_losers->count() == 0
            // ) {
            //     $st->delete();
            //     return redirect('/resultados')->withErrors('Resultados no guardados, debido a que es igual a la jugada anterior y no posse jugadas activas');
            // } else {

            return ['animal' => $animal->nombre, 'valid' => true, 'message' => 'Cantidad de Jugadas Registradas ' . $all_registers->count() . ' ,cantidad de Ganadores ' . $registers->count() . ' Cantidad de Perdedores ' . $registers_losers->count(), 'sorteo_type_id' => 4];

            // return redirect('/resultados')->withErrors('Resultados guardados, Cantidad de Jugadas Registradas ' . $all_registers->count() . ' ,cantidad de Ganadores ' . $registers->count() . ' Cantidad de Perdedores ' . $registers_losers->count());
            // }

            // return [$registers->count(), $registers_losers->count()];
        }
    }

    public static function storeDirectGeneric($animal_number, $schedule_id, $sorteo_id)
    {
        $dt2 = new DateTime(date('Y-m-d H:i:s'), new DateTimeZone('UTC'));
        $dt = $dt2->setTimezone(new DateTimeZone("America/Caracas"));

        $telegram = new Telegram();
        $animal = Animal::where('sorteo_type_id', $sorteo_id)->where('number', $animal_number)->first();
        $old = Result::where('sorteo_type_id', $sorteo_id)->orderBy('id', 'DESC')->first();

        $horarios = Schedule::where('sorteo_type_id', $sorteo_id)->get();
        $hora = $horarios[$schedule_id];

        if (!!$old) {
            if ($old->schedule_id == $hora->id && $old->animal_id == $animal->id) {
                return ['valid' => false, 'message' => 'ALERTA! Registros Similares, no se pueden guardar los resultados'];
            }
        }

        $r = Result::create([
            'schedule_id' => $hora->id,
            'animal_id' => $animal->id,
            'sorteo_type_id' => $sorteo_id,
        ]);

        $change = Exchange::all()->toArray();

        // dd($data);

        $amount_winners = 0;
        $amount_home_usd = 0;

        if ($r) {
            $__sorteo = SorteosType::find($sorteo_id);
            $all_registers = RegisterDetail::where('sorteo_type_id', $sorteo_id)->where('winner', 0)->where('schedule_id', $hora->id)->whereDate("created_at", "=", $dt->format('Y-m-d'))->get();
            $registers = RegisterDetail::where('sorteo_type_id', $sorteo_id)->where('winner', 0)->where('schedule_id', $hora->id)->where('animal_id', $animal->id)->whereDate("created_at", "=", $dt->format('Y-m-d'))->get();

            // dd(date('Y-m-d'), $registers);

            foreach ($registers as $register) {
                $register->winner = 1;
                $register->update();

                //calcular el monto en dolares de los premios


                // $key =  array_search($register->moneda_id, array_column($totalMonedas, 'id'));
                $key2 =  array_search($register->moneda_id, array_column($change, 'moneda_id'));


                $amount_winners += ($register->monto * 30) / $change[$key2]['change_usd'];

                $reg = Register::find($register->register_id);
                $reg->has_winner = 1;
                $reg->update();
            }

            $registers_losers = RegisterDetail::where('sorteo_type_id', $sorteo_id)->where('winner', 0)->where('schedule_id', $schedule_id)->where('animal_id', '!=', $animal->id)->whereDate("created_at", "=", $dt->format('Y-m-d'))->get();

            foreach ($registers_losers as $register_loser) {
                $register_loser->winner = -1;
                $register_loser->update();



                // $key =  array_search($register_loser->moneda_id, array_column($totalMonedas, 'id'));
                $key4 =  array_search($register_loser->moneda_id, array_column($change, 'moneda_id'));

                $amount_home_usd += $register_loser->monto / $change[$key4]['change_usd'];
                // $reg = Register::find($register->register_id);
                // $reg->has_winner = -1;
                // $reg->update();
            }


            $st = $r->update([
                'quantity_plays' => $all_registers->count(),
                'quantity_winners' => $registers->count(),
                'quantity_lossers' => $registers_losers->count(),
                'amount_winners_usd' => $amount_winners,
                'amount_home_usd' => $amount_home_usd,
                'amount_balance_usd' => $amount_home_usd - $amount_winners,
            ]);

            //eliminar si el nuevo  el igual al anterior pero sin cantidades
            // $old =  Result::find($st->id - 1);
            // if (
            //     $old->animal_id === $st->animal_id
            //     && $old->schedule === $st->schedule
            //     && $all_registers->count() == 0
            //     &&  $registers->count()
            //     && $registers_losers->count() == 0
            // ) {
            //     $st->delete();
            //     return redirect('/resultados')->withErrors('Resultados no guardados, debido a que es igual a la jugada anterior y no posse jugadas activas');
            // } else {

            $telegram->sendMessage('✅ ' . $__sorteo->name . ' Cantidad de Jugadas Registradas ' . $all_registers->count() . ' ,cantidad de Ganadores ' . $registers->count() . ' Cantidad de Perdedores ' . $registers_losers->count());
            return ['animal' => $animal->nombre, 'valid' => true, 'message' => 'Cantidad de Jugadas Registradas ' . $all_registers->count() . ' ,cantidad de Ganadores ' . $registers->count() . ' Cantidad de Perdedores ' . $registers_losers->count(), 'sorteo_type_id' => $sorteo_id];
            // return redirect('/resultados')->withErrors('Resultados guardados, Cantidad de Jugadas Registradas ' . $all_registers->count() . ' ,cantidad de Ganadores ' . $registers->count() . ' Cantidad de Perdedores ' . $registers_losers->count());
            // }

            // return [$registers->count(), $registers_losers->count()];
        }
    }

    public static function storeDirectGeneric2($animal_number, $schedule_position, $sorteo_id)
    {

        $old = Result::where('sorteo_type_id', $sorteo_id)->orderBy('id', 'DESC')->first();
        $animal = Animal::where('sorteo_type_id', $sorteo_id)->where('number', $animal_number)->first();
        $horarios = Schedule::where('sorteo_type_id', $sorteo_id)->get();
        $hora = $horarios[$schedule_position+1];

        $dt2 = new DateTime(date('Y-m-d H:i:s'), new DateTimeZone('UTC'));
        $dt = $dt2->setTimezone(new DateTimeZone("America/Caracas"));

        // error_log($dt->format('Y-m-d'));
        // error_log($animal);
        // error_log($hora);

        $jugadas_horario = DB::select(DB::raw("SELECT COUNT(*) AS total_jugadas FROM `register_details` where date(created_at) = date(:fecha_inicio) and schedule_id = :schedule_id"), ['fecha_inicio' => $dt->format('Y-m-d'), 'schedule_id' => $hora->id]);
        $jugadas_ganadores = DB::select(DB::raw("SELECT COUNT(*) AS total_ganadores FROM `register_details` where date(created_at) = date(:fecha_inicio) and schedule_id = :schedule_id and animal_id = :animal_id"), ['fecha_inicio' => $dt->format('Y-m-d'), 'schedule_id' => $hora->id, 'animal_id' => $animal->id]);

        DB::select(DB::raw("UPDATE `register_details` set winner = 1 where date(created_at) = date(:fecha_inicio) and schedule_id = :schedule_id and animal_id = :animal_id"), ['fecha_inicio' => $dt->format('Y-m-d'), 'schedule_id' => $hora->id, 'animal_id' => $animal->id]);
        DB::select(DB::raw("UPDATE `register_details` set winner = -1 where date(created_at) = date(:fecha_inicio) and schedule_id = :schedule_id and animal_id != :animal_id"), ['fecha_inicio' => $dt->format('Y-m-d'), 'schedule_id' => $hora->id, 'animal_id' => $animal->id]);

        // $winners = DB::select(DB::raw("SELECT register_id, COUNT(*) AS cuenta FROM `register_details` where date(created_at) = date(':fecha_inicio') and schedule_id = :schedule_id and winner = 1 GROUP BY register_id", ['fecha_inicio' => $dt->format('Y-m-d'), 'schedule_id' => $hora->id]));
        // $jugadas_horario = DB::select(DB::raw("SELECT * FROM `register_details` where date(created_at) = date(:fecha_inicio) and schedule_id = :schedule_id"), ['fecha_inicio' => $dt->format('Y-m-d'), 'schedule_id' => $hora->id]);

        // error_log(json_encode($jugadas_horario));
        // error_log($jugadas_horario[0]->total_jugadas);
        // error_log($jugadas_ganadores[0]->total_ganadores);
        // error_log($jugadas_horario[0]->total_jugadas - $jugadas_ganadores[0]->total_ganadores);

        if (!!$old) {
            if ($old->schedule_id == $hora->id && $old->animal_id == $animal->id) {
                return ['valid' => false, 'message' => 'ALERTA! Similares, no se pueden guardar los resultados'];
            }
        }


        $total =  DB::select(DB::raw("SELECT 
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
        WHERE DATE(register_details.created_at) = DATE(:fecha_inicio)

        AND register_details.schedule_id = :schedule_id"), ['fecha_inicio' => $dt->format('Y-m-d'), 'schedule_id' => $hora->id]);


        // obtener el id de los tickets para settearlos como ganadores
        $registerIds =  DB::select(DB::raw("SELECT register_id, COUNT(*) AS cuenta FROM `register_details` where date(created_at) = DATE(:fecha_inicio) and schedule_id = :schedule_id and winner = 1 GROUP BY register_id"), ['fecha_inicio' => $dt->format('Y-m-d'), 'schedule_id' => $hora->id]);


        $registerIds = new Collection($registerIds);

        $registerIds =  $registerIds->pluck('register_id');

        $reg = Register::whereIn('id', $registerIds)->update(['has_winner' => 1]);

        $r = Result::create([
            'schedule_id' => $hora->id,
            'animal_id' => $animal->id,
            'sorteo_type_id' => $sorteo_id,
            'quantity_plays' => $jugadas_horario[0]->total_jugadas,
            'quantity_lossers' => $jugadas_horario[0]->total_jugadas - $jugadas_ganadores[0]->total_ganadores,
            'quantity_winners' => $jugadas_ganadores[0]->total_ganadores,
            'amount_home_usd' =>  $total[0]->usd_monto_total,
            'amount_winners_usd' => $total[0]->usd_premio_total,
            'amount_balance_usd' => ($total[0]->usd_monto_total - $total[0]->usd_comision_total) - $total[0]->usd_premio_total,
            'valid' => true
        ]);

        return $r;
    }

    public function destroy($id)
    {

        $dt = new DateTime(date('Y-m-d H:i:s'), new DateTimeZone('UTC'));
        $dt->setTimezone(new DateTimeZone(session('timezone')));

        //deshacer la actualizacion 
        $resultado = Result::find($id);
        // dd($resultado);
        // $registros = RegisterDetail::where('schedule_id', $resultado->schedule_id)->where('sorteo_type_id', $resultado->sorteo_type_id)
        //     ->where('created_at', '>=', $dt->format('Y-m-d') . ' 00:00:00')
        //     ->get();
        // // dd($dt->format('Y-m-d'), $registros->count());

        // $registros->each(function ($items) {
        //     $items->winner = 0;
        //     $items->update();
        // });


        $rr = DB::select(DB::raw("UPDATE `register_details` set winner = 0 where date(created_at) = date(:fecha_inicio) and schedule_id = :schedule_id and animal_id = :animal_id"), ['fecha_inicio' => $dt->format('Y-m-d'), 'schedule_id' => $resultado->schedule_id, 'animal_id' => $resultado->animal_id]);
        // DB::select(DB::raw("UPDATE `register_details` set winner = -1 where date(created_at) = date(:fecha_inicio) and schedule_id = :schedule_id and animal_id != :animal_id"), ['fecha_inicio' => $dt->format('Y-m-d'), 'schedule_id' => $hora->id, 'animal_id' => $animal->id]);


        $raw = DB::select(DB::raw("SELECT id,
         (SELECT SUM( IF(register_details.winner = 1, monto, 0)) as total FROM `register_details` where register_id = registers.id) as total
         from registers
         WHERE date(created_at) =  date(:fecha_inicio)
         ORDER by registers.id DESC"), ['fecha_inicio' => $dt->format('Y-m-d')]);

        $raw = new Collection($raw);
        // dd($raw);

        $fil = $raw->filter(function ($v, $k) {
            if ($v->total > 0) {
                return  $v;
            }
        });

        // dd($fil->pluck('id'))


        $ids =  $fil->pluck('id');

        $reg = Register::whereIn('id', $ids)->update(['has_winner' => 0]);

        $resultado->delete();

        return ["valid" => true, 'message' => 'Registro eliminado correctamente'];
    }
}
