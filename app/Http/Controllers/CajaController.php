<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\CashFlow;
use App\Models\Exchange;
use App\Models\Moneda;
use App\Models\Register;
use App\Models\RegisterDetail;
use App\Models\User;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;

class CajaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('timezone');
        $this->resource = 'cajas';
        $this->comision_vendedores = 0.13;
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
            $cajas = Caja::orderBy('id', 'DESC')->paginate(50);
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

            $cajas = Caja::whereIn('user_id', $us)->orderBy('id', 'DESC')->paginate(50);
        } elseif (auth()->user()->role_id == 3) {
            $cajas = Caja::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->paginate(50);
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
        $data['admin_id'] = auth()->user()->parent_id;
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
        $resource = $this->resource;
        $caja = Caja::find($id);

        $_fecha_apertura = new DateTime($caja->fecha_apertura);
        $fecha_apertura = $_fecha_apertura->format('Y-m-d\TH:i:s');
        $fecha_ahora = new DateTime();
        $fecha_cierre = $fecha_ahora->format('Y-m-d\TH:i:s');
        $_fecha_cierre = $fecha_ahora->format('Y-m-d\TH:i:s');

        $tickets = Register::with('user', 'moneda', 'detalles')->where('caja_id', $caja->id)->get();

        // dd(->toArray());
        $tickets = $tickets->each(function ($item, $value) {

            $total = $item->detalles->sum('monto');
            $totalPremio = $item->detalles->sum(function ($vv) {
                if ($vv->winner == 1) {
                    return $vv->monto * 30;
                } else {
                    return 0;
                }
            });
            $totalPagado = $item->detalles->sum(function ($vv) {
                if ($vv->status == 1) {
                    return $vv->monto * 30;
                } else {
                    return 0;
                }
            });

            $item['_total'] = $total;
            $item['_total_premio'] = $totalPremio;
            $item['_total_pagado'] = $totalPagado;
            $item['_comision'] = $item->user->comision / 100;
            return $item;
        });


        $monedas = $tickets->groupBy('moneda_id')->toArray();
        $cashflow = CashFlow::with('moneda')->where('caja_id', $caja->id)->get()->toArray();
        $temp = [];
        foreach ($monedas as $key => $value) {
            foreach ($cashflow as $k => $v) {
                if ($v['moneda_id'] == $key) {
                    array_push($monedas[$key], $v);
                }
            }
        }


        foreach ($monedas as $key => $value) {
            $total_comision = 0;
            foreach ($value as $k => $v) {
                if (isset($v['code'])) {
                    $total_comision += $v['_total'] * $v['_comision'];
                }
            }
            array_push($monedas[$key], [
                "id" => 00,
                'type' => -1,
                'total' => $total_comision,
                'detalle' => "Comisión del vendedor",
                "moneda_id" => $value[0]['moneda']['id'],
                "moneda" => $value[0]['moneda'],
            ]);
        }

        return view('caja.balance', compact('resource', 'caja', 'fecha_apertura', 'fecha_cierre', '_fecha_cierre', 'monedas'));
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

        if ($caja->user_id == auth()->user()->id || auth()->user()->role_id == 2 || auth()->user()->role_id == 1) {
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
        $caja->admin_id = auth()->user()->parent_id;
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


    public function cajaReport(Request $request, $id)
    {
        $animalesvendidos = RegisterDetail::with('user')->where('user_id', auth()->user()->id)->where('created_at', '>=', date('Y-m-d') . ' 00:00:00')->get();

        $totalMonedas = Moneda::all()->toArray();
        $change = Exchange::all()->toArray();

        foreach ($animalesvendidos as $animalvendido) {

            //obtener el index de cada moneda
            $key =  array_search($animalvendido->moneda_id, array_column($totalMonedas, 'id'));
            $key2 =  array_search($animalvendido->moneda_id, array_column($change, 'moneda_id'));
            $caja_key =  array_search($animalvendido->caja_id, array_column($cajas, 'id'));
            $cajas[$caja_key]['totales'] = [];

            if (!isset($totalMonedas[$key]['total'])) {
                $totalMonedas[$key]['caja_id'] = $animalvendido->caja_id;
                $totalMonedas[$key]['exchange_usd'] = $change[$key2]['change_usd'];
                $totalMonedas[$key]['total'] = $animalvendido->monto;
                $totalMonedas[$key]['total_exchange_usd'] = $animalvendido->monto / $change[$key2]['change_usd'];
                $totalMonedas[$key]['comision_vendedor'] = $animalvendido->usuario->comision / 100;
            } else {
                $totalMonedas[$key]['total'] =  $totalMonedas[$key]['total'] + $animalvendido->monto;
                $totalMonedas[$key]['total_exchange_usd'] = ($animalvendido->monto / $change[$key2]['change_usd']) + $totalMonedas[$key]['total_exchange_usd'];
            }

            if (!isset($totalMonedas[$key]['total_rewards'])) {
                $totalMonedas[$key]['total_rewards'] = $animalvendido->winner == 1 ? $animalvendido->monto * $this->amount_rewards : 0.00;
            } else {
                $totalMonedas[$key]['total_rewards'] = $totalMonedas[$key]['total_rewards'] + ($animalvendido->winner == 1 ? $animalvendido->monto * $this->amount_rewards : 0.00);
            }
            // dd($animalesvendidos->count());
            // dd($animalvendido->status);
            if (!isset($totalMonedas[$key]['total_pay'])) {
                $totalMonedas[$key]['total_pay'] =  $animalvendido->status == 1 ? $animalvendido->monto * $this->amount_rewards : 0.00;
            } else {
                $totalMonedas[$key]['total_pay'] = $totalMonedas[$key]['total_pay'] + ($animalvendido->status == 1 ? $animalvendido->monto * $this->amount_rewards : 0.00);
            }
        }

        //calcular comisiones y perdidas
        foreach ($totalMonedas as $_key => $totales) {
            if (isset($totales['total'])) {
                $totales['comision'] = $totales['total'] * $this->comision_vendedores;
                $totales['comision_exchange_usd'] = ($totales['total'] * $this->comision_vendedores) / $totales['exchange_usd'];
            }

            if (isset($totales['total_rewards'])) {
                $totales['total_rewards_exchange_usd'] = $totales['total_rewards'] /  $totales['exchange_usd'];
                $totales['total_rewards_exchange_usd'] = $totales['total_rewards'] /  $totales['exchange_usd'];
            }

            if (isset($totales['total'])) {
                $totales['balance'] = $totales['total'] - $totales['total_rewards'] - $totales['comision'];
                $totales['balance_exchange_usd'] = $totales['total_exchange_usd'] - $totales['total_rewards_exchange_usd'] - $totales['comision_exchange_usd'];
            }

            if (isset($totales['total_pay'])) {
                $totales['total_pay_exchange_usd'] = $totales['total_pay'] /  $totales['exchange_usd'];
            }


            $totalMonedas[$_key] = $totales;
        }


        return response()->json($totalMonedas, 200);
    }
    public function addBalance(Request $request, $id)
    {
        $caja = Caja::with('usuario')->find($id);
        $_monedas = $caja->usuario->monedas;
        $monedas = Moneda::whereIn('id', $_monedas)->get();

        // dd($caja,$monedas);
        return view('caja.addbalance', compact('id', 'monedas'));
    }

    public function cashFlow(Request $request, $id)
    {
        $data = $request->all();
        $data['caja_id'] = $id;
        CashFlow::create($data);

        return redirect('/balance-caja/' . $id);
    }
}
