<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Caja;
use App\Models\Customer;
use App\Models\Moneda;
use App\Models\Payment;
use App\Models\Register;
use App\Models\RegisterDetail;
use App\Models\Schedule;
use Illuminate\Http\Request;

class TicketController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->resource = 'tickets';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (auth()->user()->role_id == 1) {
            $tickets = Register::with(['user', 'moneda', 'detalles'])->orderBy('id', 'desc')->paginate(10);
        } elseif (auth()->user()->role_id == 2) {
            $tickets = Register::with(['user', 'moneda', 'detalles'])->where('admin_id', auth()->user()->id)->orderBy('id', 'desc')->paginate(10);
        } elseif (auth()->user()->role_id == 3) {
            $padre = auth()->user()->parent_id;
            $tickets = Register::with(['user', 'moneda', 'detalles'])->where('admin_id', $padre)->orderBy('id', 'desc')->paginate(10);
        }

        $ticket =  $tickets->each(function ($ticket) {
            $ticket->total_premios = $ticket->detalles->sum(function ($item) {
                if ($item->winner == 1) {
                    return  floatval($item->monto * 30);
                } else {
                    return 0;
                }
            });
            $ticket->total_premios_pagados = $ticket->detalles->sum(function ($item) {
                if ($item->winner == 1 &&  $item->status == 1) {
                    return  floatval($item->monto * 30);
                } else {
                    return 0;
                }
            });

            $ticket->total_premios_pendientes = $ticket->total_premios - $ticket->total_premios_pagados;
            return $ticket;
        });

        return view('tickets.index', compact('tickets'));
    }


    public function create()
    {

        if (auth()->user()->role_id == 2) {
            return redirect('/tickets')->withErrors('⚠️ Los Administradores no pueden crear tickets');
        }


        //validar apertura de caja

        $caja = Caja::where('user_id', auth()->user()->id)->where('status', 1)->first();

        if (!!$caja) {

            $resource = $this->resource;
            $animals = Animal::all();
            $schedules = Schedule::where('status', 1)->get();
            $payments = Payment::where('status', '1')->get();
            $monedas = Moneda::whereIn('id', auth()->user()->monedas)->get();

            if (auth()->user()->role_id == 1) {
                $customers = Customer::all();
            } elseif (auth()->user()->role_id == 2) {
                $customers = Customer::where('admin_id', auth()->user()->id)->get();
            } elseif (auth()->user()->role_id == 3) {
                $padre = auth()->user()->parent_id;
                $customers = Customer::where('admin_id', $padre)->get();
            }

            return view('tickets.create', compact('resource', 'animals', 'schedules', 'customers', 'payments', 'monedas', 'caja'));
            //
        } else {
            return redirect('/cajas')->withErrors('⚠️ Es necesario aperturar tu caja para realizar ventas');
        }
    }

    public function validateToPay(Request $request, $code)
    {
        $u = auth()->user()->id;
        $ticket = Register::where('user_id', $u)->where('code', $code)->first();

        if (!!$ticket) {
            return response()->json(['valid' => true], 200);
        } else {
            return response()->json(['valid' => false], 402);
        }
    }


    public function pay(Request $request, $code)
    {
        if (auth()->user()->role_id == 1) {
            $ticket = Register::with([
                'caja',
                'user',
                'moneda'
            ])->where('code', $code)->first();
        } else {
            $ticket = Register::with([
                'caja',
                'user',
                'moneda'
            ])->where('user_id', auth()->user()->id)->where('code', $code)->first();
        }

        if (!$ticket) {
            return redirect('/tickets')->withErrors('⚠️ No tienes Autorización para realizar este pago');
        }


        $detalles = RegisterDetail::with([
            "animal",
            "schedule",
        ])->where('register_id', $ticket->id)->get();


        return view('tickets.pay', compact('ticket', 'detalles'));
    }
}
