<?php

namespace App\Http\Controllers\Hipismo;

use App\Http\Controllers\Controller;
use App\Models\Hipismo\Hipodromo;
use App\Models\Hipismo\Race;
use DateTime;
use Illuminate\Http\Request;

class RaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //`
        $races = Race::with('hipodromo')->orderBy('id', 'desc')->paginate();
        return view('hipismo.races.index', compact('races'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $hipodromos = Hipodromo::where('status', 1)->get();
        return view('hipismo.races.create', compact('hipodromos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'race_day' => 'required',
            'hipodromo_id' => 'required',
        ]);

        $data = $request->only(['name', 'race_day', 'hipodromo_id']);

        try {
            $r = new Race($data);
            $r->save();
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
            // return redirect('/hipismo/hipodromos',302,['success'=>'guardado correctamente']);
        }
        return redirect('/hipismo/races')->with('success', 'Guardado Correctamente');
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
        $hipodromos = Hipodromo::where('status', 1)->get();
        $race = Race::find($id);
        $fecha = new DateTime($race->race_day);
        $fecha = $fecha->format('Y-m-d');
        return view('hipismo.races.edit', compact('hipodromos', 'race', 'fecha'));
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
        $request->validate([
            'name' => 'required',
            'race_day' => 'required',
            'hipodromo_id' => 'required',
        ]);

        $data = $request->only(['name', 'race_day', 'hipodromo_id']);
        try {

            $r = Race::find($id);
            $r->update($data);
            // $r->save();
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
            // return redirect('/hipismo/hipodromos',302,['success'=>'guardado correctamente']);
        }
        return redirect('/hipismo/races')->with('success', 'Guardado Correctamente');
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

    public function setting($id)
    {
        $race = Race::with('fixtures')->find($id);
        return view('hipismo.races.setting', compact('race'));
    }
}
