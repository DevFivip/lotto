<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->resource = 'customers';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->role_id == 1) {
            $customers = Customer::all();
        } elseif (auth()->user()->role_id == 2) {
            $customers = Customer::where('admin_id', auth()->user()->id)->get();
        } elseif (auth()->user()->role_id == 3) {
            $padre = auth()->user()->parent_id;
            $customers = Customer::where('admin_id', $padre)->get();
        }

        $resource = $this->resource;
        return view('customers.index', compact('resource', 'customers'));

        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $resource = $this->resource;
        return view('customers.create', compact('resource'));
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

        Customer::create($data);

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
        //

        //validar que el cliente que se vaya a editar sea de mi pertenencia

        if (auth()->user()->role_id == 1) {
            $customer = Customer::find($id);
        } elseif (auth()->user()->role_id == 2) {
            $customer = Customer::where('admin_id', auth()->user()->id)->where('id', $id)->first();
        } elseif (auth()->user()->role_id == 3) {
            $customer = Customer::where('admin_id', auth()->user()->parent_id)->where('id', $id)->first();
        }

        if (!!!$customer) {
            return redirect()->back()->withErrors("No se puede editar este cliente, no posees los permisos necesarios");
        }


        $resource = $this->resource;
        return view('customers.edit', compact('resource', 'customer'));
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
        $data = $request->all();
        $customer = Customer::find($id);
        $customer->update($data);

        return redirect('/' . $this->resource);
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
