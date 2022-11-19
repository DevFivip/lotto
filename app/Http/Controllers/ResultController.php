<?php

namespace App\Http\Controllers;

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

class ResultController extends Controller
{


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

            $all_registers = RegisterDetail::where('winner', 0)->where("sorteo_type_id", $sorteo_type_id)->where('schedule_id', $schedule_id)->get();
            $registers = RegisterDetail::where('winner', 0)->where('schedule_id', $schedule_id)->where('animal_id', $animal->id)->where('sorteo_type_id', $sorteo_type_id)->get();

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

            $registers_losers = RegisterDetail::where('winner', 0)->where('schedule_id', $schedule_id)->where('animal_id', '!=', $animal->id)->where('sorteo_type_id', $sorteo_type_id)->get();

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
    public static function storeDirect($animal_number, $schedule_id) //store de lotto
    {

        // $schedule_id = $data['schedule_id'];
        // $animal_number = $data['animal_id'];

        $animal = Animal::where('sorteo_type_id', 1)->where('number', $animal_number)->first();

        $old = Result::where('sorteo_type_id', 1)->orderBy('id', 'DESC')->first();

        if ($old->schedule_id == $schedule_id && $old->animal_id == $animal->id) {
            return ['valid' => false, 'message' => 'ALERTA! Registros Similares, no se pueden guardar los resultados'];
        }

        $r =  Result::create([
            'schedule_id' => $schedule_id,
            'animal_id' => $animal->id,
            'sorteo_type_id' => 1,
        ]);

        $totalMonedas = Moneda::all()->toArray();
        $change = Exchange::all()->toArray();

        // dd($data);


        $amount_winners = 0;
        $amount_home_usd = 0;

        if ($r) {

            $all_registers = RegisterDetail::where('sorteo_type_id', 1)->where('winner', 0)->where('schedule_id', $schedule_id)->get();
            $registers = RegisterDetail::where('sorteo_type_id', 1)->where('winner', 0)->where('schedule_id', $schedule_id)->where('animal_id', $animal->id)->get();

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

            $registers_losers = RegisterDetail::where('sorteo_type_id', 1)->where('winner', 0)->where('schedule_id', $schedule_id)->where('animal_id', '!=', $animal->id)->get();

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
            return ['animal' => $animal->nombre, 'valid' => true, 'message' => 'Cantidad de Jugadas Registradas ' . $all_registers->count() . ' ,cantidad de Ganadores ' . $registers->count() . ' Cantidad de Perdedores ' . $registers_losers->count(), 'sorteo_type_id' => 1];
            // return redirect('/resultados')->withErrors('Resultados guardados, Cantidad de Jugadas Registradas ' . $all_registers->count() . ' ,cantidad de Ganadores ' . $registers->count() . ' Cantidad de Perdedores ' . $registers_losers->count());
            // }

            // return [$registers->count(), $registers_losers->count()];
        }
    }
    public static function storeDirectGranjita($animal_number, $schedule_id)
    {

        $animal = Animal::where('sorteo_type_id', 2)->where('number', $animal_number)->first();

        $old = Result::where('sorteo_type_id', 2)->orderBy('id', 'DESC')->first();

        //obtener la posicion del horario
        $horarios = Schedule::where('sorteo_type_id', 2)->get();
        $hora = $horarios[$schedule_id - 1];

        if ($old->schedule_id ==  $hora->id && $old->animal_id == $animal->id) {
            return ['valid' => false, 'message' => 'ALERTA! Registros Similares, no se pueden guardar los resultados'];
        }

        $r =  Result::create([
            'schedule_id' =>  $hora->id,
            'animal_id' => $animal->id,
            'sorteo_type_id' => 2,
        ]);

        $totalMonedas = Moneda::all()->toArray();
        $change = Exchange::all()->toArray();

        // dd($data);

        $amount_winners = 0;
        $amount_home_usd = 0;

        if ($r) {

            $all_registers = RegisterDetail::where('sorteo_type_id', 2)->where('winner', 0)->where('schedule_id', $hora->id)->get();
            $registers = RegisterDetail::where('sorteo_type_id', 2)->where('winner', 0)->where('schedule_id', $hora->id)->where('animal_id', $animal->id)->get();

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

            $registers_losers = RegisterDetail::where('sorteo_type_id', 2)->where('winner', 0)->where('schedule_id', $hora->id)->where('animal_id', '!=', $animal->id)->get();

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
            return ['animal' => $animal->nombre, 'valid' => true, 'message' => 'Cantidad de Jugadas Registradas ' . $all_registers->count() . ' ,cantidad de Ganadores ' . $registers->count() . ' Cantidad de Perdedores ' . $registers_losers->count(), 'sorteo_type_id' => 2];
            // return redirect('/resultados')->withErrors('Resultados guardados, Cantidad de Jugadas Registradas ' . $all_registers->count() . ' ,cantidad de Ganadores ' . $registers->count() . ' Cantidad de Perdedores ' . $registers_losers->count());
            // }

            // return [$registers->count(), $registers_losers->count()];
        }
    }
    public static function storeDirectSelvaParaiso($animal_number, $schedule_id)
    {

        $animal = Animal::where('sorteo_type_id', 3)->where('number', $animal_number)->first();
        $old = Result::where('sorteo_type_id', 3)->orderBy('id', 'DESC')->first();


        if (!!$old) {
            if ($old->schedule_id == $schedule_id && $old->animal_id == $animal->id) {
                return ['valid' => false, 'message' => 'ALERTA! Registros Similares, no se pueden guardar los resultados'];
            }
        }

        $r =  Result::create([
            'schedule_id' => $schedule_id,
            'animal_id' => $animal->id,
            'sorteo_type_id' => 3,
        ]);

        $totalMonedas = Moneda::all()->toArray();
        $change = Exchange::all()->toArray();

        // dd($data);

        $amount_winners = 0;
        $amount_home_usd = 0;

        if ($r) {

            $all_registers = RegisterDetail::where('sorteo_type_id', 3)->where('winner', 0)->where('schedule_id', $schedule_id)->get();
            $registers = RegisterDetail::where('sorteo_type_id', 3)->where('winner', 0)->where('schedule_id', $schedule_id)->where('animal_id', $animal->id)->get();

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

            $registers_losers = RegisterDetail::where('sorteo_type_id', 3)->where('winner', 0)->where('schedule_id', $schedule_id)->where('animal_id', '!=', $animal->id)->get();

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
            return ['animal' => $animal->nombre, 'valid' => true, 'message' => 'Cantidad de Jugadas Registradas ' . $all_registers->count() . ' ,cantidad de Ganadores ' . $registers->count() . ' Cantidad de Perdedores ' . $registers_losers->count(), 'sorteo_type_id' => 2];
            // return redirect('/resultados')->withErrors('Resultados guardados, Cantidad de Jugadas Registradas ' . $all_registers->count() . ' ,cantidad de Ganadores ' . $registers->count() . ' Cantidad de Perdedores ' . $registers_losers->count());
            // }

            // return [$registers->count(), $registers_losers->count()];
        }
    }
    public static function storeDirectLottoPlus($animal_number, $schedule_id)
    {

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

            $all_registers = RegisterDetail::where('sorteo_type_id', 4)->where('winner', 0)->where('schedule_id', $schedule_id)->get();
            $registers = RegisterDetail::where('sorteo_type_id', 4)->where('winner', 0)->where('schedule_id', $schedule_id)->where('animal_id', $animal->id)->get();

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

            $registers_losers = RegisterDetail::where('sorteo_type_id', 4)->where('winner', 0)->where('schedule_id', $schedule_id)->where('animal_id', '!=', $animal->id)->get();

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $dt = new DateTime(date('Y-m-d H:i:s'), new DateTimeZone('UTC'));
        $dt->setTimezone(new DateTimeZone(session('timezone')));

        //deshacer la actualizacion 
        $resultado = Result::find($id);
        // dd($resultado);
        $registros = RegisterDetail::where('schedule_id', $resultado->schedule_id)->where('sorteo_type_id', $resultado->sorteo_type_id)
            ->where('created_at', '>=', $dt->format('Y-m-d') . ' 00:00:00')
            ->get();
        // dd($dt->format('Y-m-d'), $registros->count());


        $registros->each(function ($items) {
            $items->winner = 0;
            $items->update();
        });

        $resultado->delete();
        return ["valid" => true, 'message' => 'Registro eliminado correctamente'];
    }
}
