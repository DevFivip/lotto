<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Exchange;
use App\Models\Moneda;
use App\Models\Register;
use App\Models\RegisterDetail;
use App\Models\Result;
use App\Models\Schedule;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;

class ResultController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = Result::where('created_at', '>=', date('Y-m-d') . ' 00:00:00')->paginate(11);
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
        $animalitos = Animal::all();
        $schedules = Schedule::all();
        return view('results.create', compact('animalitos', 'schedules'));
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

        $animal = Animal::where('number', $animal_number)->first();

        $old = Result::orderBy('id', 'DESC')->first();


        if ($old->schedule_id == $schedule_id && $old->animal_id == $animal->id) {
            return redirect('/resultados')->withErrors('ALERTA! Registros Similares, no se pueden guardar los resultados');
        }


        $r =  Result::create([
            'schedule_id' => $schedule_id,
            'animal_id' => $animal->id,
        ]);

        $totalMonedas = Moneda::all()->toArray();
        $change = Exchange::all()->toArray();


        $amount_winners = 0;
        $amount_home_usd = 0;

        if ($r) {


            $all_registers = RegisterDetail::where('winner', 0)->where('schedule_id', $schedule_id)->get();
            $registers = RegisterDetail::where('winner', 0)->where('schedule_id', $schedule_id)->where('animal_id', $animal->id)->get();

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

            $registers_losers = RegisterDetail::where('winner', 0)->where('schedule_id', $schedule_id)->where('animal_id', '!=', $animal->id)->get();

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

    public static function storeDirect($animal_number, $schedule_id)
    {

        // $schedule_id = $data['schedule_id'];
        // $animal_number = $data['animal_id'];

        $animal = Animal::where('number', $animal_number)->first();

        $old = Result::orderBy('id', 'DESC')->first();

        if ($old->schedule_id == $schedule_id && $old->animal_id == $animal->id) {
            return ['valid' => false, 'message' => 'ALERTA! Registros Similares, no se pueden guardar los resultados'];
        }

        $r =  Result::create([
            'schedule_id' => $schedule_id,
            'animal_id' => $animal->id,
        ]);

        $totalMonedas = Moneda::all()->toArray();
        $change = Exchange::all()->toArray();

        // dd($data);

        $amount_winners = 0;
        $amount_home_usd = 0;

        if ($r) {

            $all_registers = RegisterDetail::where('winner', 0)->where('schedule_id', $schedule_id)->get();
            $registers = RegisterDetail::where('winner', 0)->where('schedule_id', $schedule_id)->where('animal_id', $animal->id)->get();

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

            $registers_losers = RegisterDetail::where('winner', 0)->where('schedule_id', $schedule_id)->where('animal_id', '!=', $animal->id)->get();

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
            return ['animal' => $animal->nombre, 'valid' => true, 'message' => 'Cantidad de Jugadas Registradas ' . $all_registers->count() . ' ,cantidad de Ganadores ' . $registers->count() . ' Cantidad de Perdedores ' . $registers_losers->count()];
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
        //
    }
}
