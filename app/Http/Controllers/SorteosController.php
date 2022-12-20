<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\AnimalitoScheduleLimit;
use App\Models\Schedule;
use App\Models\SorteosType;
use Illuminate\Http\Request;

class SorteosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sorteos = SorteosType::all();
        return view('loteries.index', compact('sorteos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $sorteo = SorteosType::find($id);

        return view('loteries.edit', compact('sorteo'));
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


        $sorteo = SorteosType::find(intval($id));
        $data = $request->all();

        // dd($data);
        // $sorteo = $data;
        $sorteo->update($data);

        // $animal->update($data);

        return redirect('/sorteos');
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
    public function limitesSettings($id) // id as sorteo_id
    {
        try {

            $sorteo = SorteosType::find($id);
            $schedules = Schedule::where('sorteo_type_id', $id)->get();
            $animals = Animal::where('sorteo_type_id', $id)->get();

            foreach ($schedules as $key => $schedule) {
                foreach ($animals as $key1 => $animal) {
                    //validamos

                    $iss = AnimalitoScheduleLimit::where('animal_id', $animal->id)->where('schedule_id', $schedule->id)->first();

                    if ($iss == null) {
                        AnimalitoScheduleLimit::create([
                            'animal_id' => $animal->id,
                            'schedule_id' => $schedule->id,
                            'limit' => $sorteo->limit_max,
                        ]);
                    } else {
                        // dd($animal->id, $schedule->id, $sorteo->limit_max);
                        $iss->animal_id = $animal->id;
                        $iss->schedule_id = $schedule->id;
                        $iss->limit = $sorteo->limit_max;
                        $iss->update();
                    }
                }
            }

            return response()->json(['valid' => true], 200);
        } catch (\Throwable $th) {

            return response()->json(['valid' => false, 'msj' => $th->getMessage()], 400);
        }
    }
}
