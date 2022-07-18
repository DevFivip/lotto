<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Customer;
use App\Models\Moneda;
use App\Models\Payment;
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

        return view('tickets.index', compact('resource', 'animals', 'schedules', 'customers', 'payments', 'monedas'));
        //
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
}
