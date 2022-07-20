<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\User;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;

class CajaController extends Controller
{
    public function __construct()
    {
        $this->resource = 'cajas';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $cajas = Caja::with('usuario')->orderBy('id', 'DESC')->get();

        if (auth()->user()->role_id == 1) {
            $cajas = Caja::orderBy('id', 'DESC')->paginate();
        } elseif (auth()->user()->role_id == 2) {

            $users = User::select('id')->where('parent_id', auth()->user()->id)->get();
            // dd($users);
            // dd($users);
            // $u = $users->implode('id', ',');
            // $ff = explode(',', $u);

            $us = [];

            for ($h = 0; $h < $users->count(); $h++) {
                array_push($us, $users[$h]['id']);
            }

            array_push($us, auth()->user()->id);

            $cajas = Caja::whereIn('user_id', $us)->orderBy('id', 'DESC')->paginate();
        } elseif (auth()->user()->role_id == 3) {
            $cajas = Caja::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->paginate();
        }
        // elseif (auth()->user()->role_id == 2) {
        //     $users = User::select('id')->where('parent_id', auth()->user()->id)->get();
        //     $u = [];
        //     for ($y = 0; $y < $users->count(); $y++) {
        //         array_push($u, $users[$y]['id']);
        //     }
        //     $cajas = Caja::whereIn('user_id', $u)->orderBy('id','DESC')->paginate();
        // } elseif (auth()->user()->role_id == 3) {
        //     $cajas = Caja::where('user_id', auth()->user()->id)->get();
        // }



        $resource = $this->resource;
        return view('caja.index', compact('cajas', 'resource'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if (auth()->user()->role_id == 2) {
            return redirect('/cajas')->withErrors('⚠️ Los Administradores no pueden aperturar cajas');
        }

        $user = auth()->user();
        $caja = Caja::where('user_id', $user->id)->where('status', 1)->first();

        if (!!!$caja) {
            $resource = $this->resource;
            $_fecha_apertura = new DateTime();

            $fecha = $_fecha_apertura->format('Y-m-d');
            $hora = $_fecha_apertura->format('H:i');
            $fecha_apertura = $fecha . 'T' . $hora . 'Z';
            return view('caja.apertura', compact('resource', 'user', 'fecha_apertura', '_fecha_apertura'));
        } else {
            return redirect()->back()->withErrors("Ya posees una caja aperturada");
        }
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

        $data = $request->all();

        // $fecha = new DateTime($data['fecha_apertura']);
        // dd($fecha);
        // $f = $fecha->setTimezone(new DateTimeZone("UTC"));
        // $data['fecha_apertura'] = $fecha;

        Caja::create($data);
        return redirect('/' . $this->resource);
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
        $caja = Caja::find($id);

        if ($caja->user_id === auth()->user()->id || auth()->user()->role_id === 2 || auth()->user()->role_id === 1) {
            $resource = $this->resource;

            $_fecha_apertura = new DateTime($caja->fecha_apertura);
            // $fecha = $_fecha_apertura->format('Y-m-d');
            // $hora = $_fecha_apertura->format('H:i');
            // $fecha_apertura = $fecha . 'T' . $hora . 'Z';
            $fecha_apertura = $_fecha_apertura->format('Y-m-d\TH:i:s');

            $fecha_ahora = new DateTime();
            // $fecha = $fecha_ahora->format('Y-m-d');
            // $hora = $fecha_ahora->format('H:i');
            // $fecha_cierre = $fecha . 'T' . $hora . 'Z';

            $fecha_cierre = $fecha_ahora->format('Y-m-d\TH:i:s');
            $_fecha_cierre = $fecha_ahora->format('Y-m-d\TH:i:s');

            return view('caja.cierre', compact('resource', 'caja', 'fecha_apertura', 'fecha_cierre', '_fecha_cierre'));
        } else {
            return redirect()->back()->withErrors("No puedes cerrar esta caja porque le pertenece a otro usuario");
        }
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
        $data = $request->all();

        $caja = Caja::find($id);

        $caja->update($data);

        return redirect('/' . $this->resource);
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function report(Request $request, $id)
    {

        $caja  = Caja::find($id);

        if (auth()->user()->role_id == 1) {
            return $caja;
        } elseif (auth()->user()->role_id == 2) {
            $us = User::find($caja->user_id);
            if (auth()->user()->id == $us->id) {
                return $caja;
            }
        } elseif (auth()->user()->role_id == 3) {
            if (auth()->user()->id == $caja->id) {
                return $caja;
            }
        } else {
            return ['Error'];
        }
    }



    public function destroy($id)
    {
        //
    }
}
