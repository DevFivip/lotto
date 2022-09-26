<?php

namespace App\Http\Controllers;

use App\Models\CajaRegister;
use App\Models\User;
use Illuminate\Http\Request;

class CajaRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(auth()->user()->role_id == 1){
            $taquillas = User::where("role_id",3)->get();
        }

        if(auth()->user()->role_id == 2){
            $taquillas = User::where('parent_id',auth()->user()->id)->where("role_id",3)->get();
        }

        return view('caja_register.index',compact('taquillas'));

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

    /**
     * Crear nuevo registro de caja register.
     *
     * @param  int  $id as id caja
     * @return \json $valores de la caja_register nuevo
     */
    public function makeCaja()
    {
        //
    }
}
