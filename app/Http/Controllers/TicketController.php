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
use App\Models\User;
use Illuminate\Http\Request;

class TicketController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('timezone');
        $this->resource = 'tickets';
    }

    public function index(Request $request)
    {
        $filter = $request->query();
        if (auth()->user()->role_id == 1) {
            $tickets = Register::with(['user', 'moneda', 'detalles'])->orderBy('id', 'desc');

            if (isset($filter['has_winner'])) {
                $tickets = $tickets->where('has_winner', $filter['has_winner']);
            }

            if (isset($filter['moneda_id'])) {
                $tickets = $tickets->where('moneda_id', $filter['moneda_id']);
            }
            if (isset($filter['user_id'])) {
                $tickets = $tickets->where('user_id', $filter['user_id']);
            }
            if (isset($filter['created_at_inicio'])) {
                $tickets = $tickets->where('created_at', '>=', $filter['created_at_inicio'] . ' 00:00:00');
            }
            if (isset($filter['created_at_final'])) {
                $tickets = $tickets->where('created_at', '<=', $filter['created_at_final'] . ' 23:59:59');
            }
            $tickets = $tickets->paginate(isset($filter['_perPage']) ? $filter['_perPage'] : 10)->appends(request()->query());
            $usuarios = User::all();
        } elseif (auth()->user()->role_id == 2) {
            $tickets = Register::with(['user', 'moneda', 'detalles'])->where('admin_id', auth()->user()->id)->orderBy('id', 'desc');

            if (isset($filter['has_winner'])) {
                $tickets = $tickets->where('has_winner', $filter['has_winner']);
            }

            if (isset($filter['moneda_id'])) {
                $tickets = $tickets->where('moneda_id', $filter['moneda_id']);
            }

            if (isset($filter['user_id'])) {
                $tickets = $tickets->where('user_id', $filter['user_id']);
            }
            if (isset($filter['created_at_inicio'])) {
                $tickets = $tickets->where('created_at', '>=', $filter['created_at_inicio'] . ' 00:00:00');
            }
            if (isset($filter['created_at_final'])) {
                $tickets = $tickets->where('created_at', '<=', $filter['created_at_final'] . ' 23:59:59');
            }
            if (isset($filter['created_at_final'])) {
                $tickets = $tickets->where('created_at', '<=', $filter['created_at_final'] . ' 23:59:59');
            }
            $tickets = $tickets->paginate(isset($filter['_perPage']) ? $filter['_perPage'] : 10)->appends(request()->query());
            $usuarios = User::where('parent_id', auth()->user()->id)->get();
        } elseif (auth()->user()->role_id == 3) {
            // $padre = auth()->user()->parent_id;
            $tickets = Register::with(['user', 'moneda', 'detalles'])->where('user_id', auth()->user()->id)->orderBy('id', 'desc');

            if (isset($filter['has_winner'])) {
                $tickets = $tickets->where('has_winner', $filter['has_winner']);
            }

            if (isset($filter['moneda_id'])) {
                $tickets = $tickets->where('moneda_id', $filter['moneda_id']);
            }
            if (isset($filter['created_at_inicio'])) {
                $tickets = $tickets->where('created_at', '>=', $filter['created_at_inicio'] . ' 00:00:00');
            }
            if (isset($filter['created_at_final'])) {
                $tickets = $tickets->where('created_at', '<=', $filter['created_at_final'] . ' 23:59:59');
            }
            $tickets = $tickets->paginate(isset($filter['_perPage']) ? $filter['_perPage'] : 10)->appends(request()->query());
            $usuarios = null;
        }

        $ticket =  $tickets->each(function ($ticket) {

            $ticket->total_premios = $ticket->detalles->sum(function ($item) {

                $reward_porcent = 0;
                switch ($item->sorteo_type_id) {
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


                if ($item->winner == 1) {
                    return  floatval($item->monto * $reward_porcent);
                } else {
                    return 0;
                }
            });
            $ticket->total_premios_pagados = $ticket->detalles->sum(function ($item) {

                $reward_porcent = 0;
                switch ($item->sorteo_type_id) {
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


                if ($item->winner == 1 &&  $item->status == 1) {
                    return  floatval($item->monto * $reward_porcent);
                } else {
                    return 0;
                }
            });

            $ticket->total_premios_pendientes = $ticket->total_premios - $ticket->total_premios_pagados;
            return $ticket;
        });

        $monedas = Moneda::whereIn('id', auth()->user()->monedas)->get();

        // dd($monedas);

        return view('tickets.index', compact('tickets', 'monedas', 'filter', 'usuarios'));
    }

    public function create()
    {

        // if (auth()->user()->role_id == 1) {
        //     return redirect('/tickets')->withErrors('⚠️ Los Administradores no pueden crear tickets');
        // }

        if (auth()->user()->role_id == 2) {
            return redirect('/tickets')->withErrors('⚠️ Los Administradores no pueden crear tickets');
        }

        //validar apertura de caja

        $caja = Caja::where('user_id', auth()->user()->id)->where('status', 1)->first();

        if (!!$caja) {

            $resource = $this->resource;
            $animals = Animal::with('type')->get();
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
    public function repeat(Request $request)
    {

        $code = $request->all()['code'];

        // if (auth()->user()->role_id == 1) {
        //     $ticket = Register::with([
        //         'caja',
        //         'user',
        //         'moneda'
        //     ])->where('code', $code)->first();
        // } else {

        $ticket = Register::with([
            'caja',
            'user',
            'moneda'
        ])->where('user_id', auth()->user()->id)->where('code', $code)->first();

        // }

        $detalles = RegisterDetail::with([
            "animal",
            "schedule",
        ])->where('register_id', $ticket->id)->get();


        $schedules = Schedule::where('status', 1)->get();

        return view('tickets.repeat', compact('ticket', 'detalles', 'schedules'));
    }
}
