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
use App\Models\SorteosType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

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
            if (isset($filter['animal_id'])) {
                //    dd($filter['animal_id']);
                // $selected  = new Collection($filter['animal_id']);
                // $animals = $selected->map((function ($v, $k) {
                //     return intval($v);
                // }));
                $details = RegisterDetail::whereIn('animal_id', $filter['animal_id']);
                // dd($details->get(), $filter['animal_id']);

                if (isset($filter['created_at_inicio'])) {
                    $details = $details->where('created_at', '>=', $filter['created_at_inicio'] . ' 00:00:00');
                }
                if (isset($filter['created_at_final'])) {
                    $details = $details->where('created_at', '<=', $filter['created_at_final'] . ' 23:59:59');
                }

                $details = $details->get();

                $ids = $details->pluck('register_id');

                $tickets = $tickets->whereIn('id', $ids);
            }

            $tickets = $tickets->paginate(isset($filter['_perPage']) ? $filter['_perPage'] : 10)->appends(request()->query());
            $usuarios = User::orderBy('taquilla_name', 'ASC')->get();
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
            if (isset($filter['animal_id'])) {
                //    dd($filter['animal_id']);
                // $selected  = new Collection($filter['animal_id']);
                // $animals = $selected->map((function ($v, $k) {
                //     return intval($v);
                // }));
                $details = RegisterDetail::whereIn('animal_id', $filter['animal_id']);
                // dd($details->get(), $filter['animal_id']);

                if (isset($filter['created_at_inicio'])) {
                    $details = $details->where('created_at', '>=', $filter['created_at_inicio'] . ' 00:00:00');
                }
                if (isset($filter['created_at_final'])) {
                    $details = $details->where('created_at', '<=', $filter['created_at_final'] . ' 23:59:59');
                }

                $details = $details->get();

                $ids = $details->pluck('register_id');

                $tickets = $tickets->whereIn('id', $ids);
            }

            $tickets = $tickets->paginate(isset($filter['_perPage']) ? $filter['_perPage'] : 10)->appends(request()->query());
            $usuarios = User::where('parent_id', auth()->user()->id)->orderBy('taquilla_name', 'desc')->get();
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

            if (isset($filter['animal_id'])) {
                //    dd($filter['animal_id']);
                // $selected  = new Collection($filter['animal_id']);
                // $animals = $selected->map((function ($v, $k) {
                //     return intval($v);
                // }));
                $details = RegisterDetail::whereIn('animal_id', $filter['animal_id']);
                // dd($details->get(), $filter['animal_id']);

                if (isset($filter['created_at_inicio'])) {
                    $details = $details->where('created_at', '>=', $filter['created_at_inicio'] . ' 00:00:00');
                }
                if (isset($filter['created_at_final'])) {
                    $details = $details->where('created_at', '<=', $filter['created_at_final'] . ' 23:59:59');
                }

                $details = $details->get();

                $ids = $details->pluck('register_id');

                $tickets = $tickets->whereIn('id', $ids);
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
        $animalitos = Animal::with('type')->get();
        // dd($animalitos[1]->type->name);

        return view('tickets.index', compact('tickets', 'monedas', 'filter', 'usuarios', 'animalitos'));
    }

    public function create()
    {

        if (auth()->user()->status == 0) {
            return redirect('/tickets')->withErrors('⚠️ Usuario desactivado contactate con tu proveedor');
        }

        if (auth()->user()->role_id == 2) {
            return redirect('/tickets')->withErrors('⚠️ Los Administradores no pueden crear tickets');
        }

        // validar apertura de caja

        $caja = Caja::where('user_id', auth()->user()->id)->where('status', 1)->first();


        if (!!$caja) {

            if (auth()->user()->sorteos == null) {
                $sorteos = SorteosType::where('status', 1)->get();
                // dd('isnull');
            } else {
                // dd(auth());
                $sorteos = SorteosType::whereIn('id', auth()->user()->sorteos)->where('status', 1)->get();
            }
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

            return view('tickets.create', compact('resource', 'animals', 'schedules', 'customers', 'payments', 'monedas', 'caja', 'sorteos'));
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

    public function POS()
    {

        if (auth()->user()->status == 0) {
            return redirect('/tickets')->withErrors('⚠️ Usuario desactivado contactate con tu proveedor');
        }

        if (auth()->user()->role_id == 2) {
            return redirect('/tickets')->withErrors('⚠️ Los Administradores no pueden crear tickets');
        }

        // validar apertura de caja

        $caja = Caja::where('user_id', auth()->user()->id)->where('status', 1)->first();


        if (!!$caja) {

            if (auth()->user()->sorteos == null) {
                $sorteos = SorteosType::where('status', 1)->get();
                // dd('isnull');
            } else {
                // dd(auth());
                $sorteos = SorteosType::whereIn('id', auth()->user()->sorteos)->where('status', 1)->get();
            }
            $resource = $this->resource;
            $animals = Animal::with('type')->get();

            $schedules = Schedule::where('status', 1)->with('type')->get();

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

            return view('tickets.POS', compact('resource', 'animals', 'schedules', 'customers', 'payments', 'monedas', 'caja', 'sorteos'));
            //
        } else {
            return redirect('/cajas')->withErrors('⚠️ Es necesario aperturar tu caja para realizar ventas');
        }
    }
}
