<?php

namespace App\Http\Controllers\Hipismo;

use App\Http\Controllers\Controller;
use App\Models\Hipismo\Hipodromo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class HipodromoController extends Controller
{
    //
    public function index()
    {
        $hipodromos = Hipodromo::paginate();
        return view('hipismo.hipodromos.index', compact('hipodromos'));
    }
    public function create()
    {
        return view('hipismo.hipodromos.create');
    }
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'country' => 'required',
        ]);

        $data = $request->only(['name', 'country', 'flag']);
        try {
            $h = new Hipodromo($data);
            $h->save();
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
            // return redirect('/hipismo/hipodromos',302,['success'=>'guardado correctamente']);
        }
        return redirect('/hipismo/hipodromos')->with('success', 'guardado correctamente');
    }

    public function edit($id)
    {
        $hipodromo = Hipodromo::find($id);
        return view('hipismo.hipodromos.edit', compact('hipodromo'));
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'country' => 'required',
        ]);

        $data = $request->only(['name', 'country', 'flag']);
        try {

            $h = Hipodromo::find($id);
            $h->update($data);
            // $h->save();
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
            // return redirect('/hipismo/hipodromos',302,['success'=>'guardado correctamente']);
        }
        return redirect('/hipismo/hipodromos')->with('success', 'guardado correctamente');
    }

    public function disable($id)
    {
        $h = Hipodromo::find($id);
        $h->status = !$h->status;
        $h->update();

        return redirect('/hipismo/hipodromos')->with('success', 'Actualizado correctamente');
    }
}
