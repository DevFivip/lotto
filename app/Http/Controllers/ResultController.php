<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Register;
use App\Models\RegisterDetail;
use App\Models\Result;
use App\Models\Schedule;
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
        $results = Result::paginate(11);
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

        $r =  Result::create([
            'schedule_id' => $schedule_id,
            'animal_id' => $animal->id,
        ]);

        if ($r) {
            $registers = RegisterDetail::where('winner', 0)->where('schedule_id', $schedule_id)->where('animal_id', $animal->id)->where('created_at', '>=', date('Y-m-d') . ' 00:00:00')->get();

            foreach ($registers as $register) {
                $register->winner = 1;
                $register->update();

                $reg = Register::find($register->register_id);
                $reg->has_winner = 1;
                $reg->update();
            }

            $registers_losers = RegisterDetail::where('winner', 0)->where('schedule_id', $schedule_id)->where('animal_id', '!=', $animal->id)->where('created_at', '>=', date('Y-m-d') . ' 00:00:00')->get();

            foreach ($registers_losers as $register_loser) {
                $register_loser->winner = -1;
                $register_loser->update();

                // $reg = Register::find($register->register_id);
                // $reg->has_winner = 1;
                // $reg->update();

            }
            return redirect('/resultados')->withErrors('Resultados guardados Cantidad de Ganadores ' . $registers->count() . ' cantidad de perdedores ' . $registers_losers->count());
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
