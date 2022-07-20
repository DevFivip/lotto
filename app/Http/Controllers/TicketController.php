<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Customer;
use App\Models\Moneda;
use App\Models\Payment;
use App\Models\Register;
use App\Models\Schedule;
use Illuminate\Http\Request;

class TicketController extends Controller
{

    public function __construct()
    {
        $this->resource = 'tickets';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (auth()->user()->role_id === 1) {
            $tickets = Register::with(['user', 'moneda'])->orderBy('id', 'desc')->paginate(10);
        } elseif (auth()->user()->role_id === 2) {
            $tickets = Register::with(['user', 'moneda'])->where('admin_id', auth()->user()->id)->orderBy('id', 'desc')->paginate(10);
        } elseif (auth()->user()->role_id === 3) {
            $padre = auth()->user()->parent_id;
            $tickets = Register::with(['user', 'moneda'])->where('admin_id', $padre)->orderBy('id', 'desc')->paginate(10);
        }

        return view('tickets.index', compact('tickets'));
    }


    public function create()
    {
        $resource = $this->resource;
        $animals = Animal::all();
        $schedules = Schedule::where('status', 1)->get();
        $payments = Payment::where('status', '1')->get();
        $monedas = Moneda::whereIn('id', auth()->user()->monedas)->get();

        if (auth()->user()->role_id === 1) {
            $customers = Customer::all();
        } elseif (auth()->user()->role_id === 2) {
            $customers = Customer::where('admin_id', auth()->user()->id)->get();
        } elseif (auth()->user()->role_id === 3) {
            $padre = auth()->user()->parent_id;
            $customers = Customer::where('admin_id', $padre)->get();
        }

        return view('tickets.create', compact('resource', 'animals', 'schedules', 'customers', 'payments', 'monedas'));
        //
    }
}
