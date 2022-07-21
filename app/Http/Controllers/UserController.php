<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Moneda;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->resource = 'usuarios';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resource = $this->resource;

        if (auth()->user()->role_id == 1) {
            $usuarios = User::all();
        } elseif (auth()->user()->role_id == 2) {
            $usuarios = User::where('parent_id', auth()->user()->id)->get();
        }


        return view('user.index', compact('usuarios', 'resource'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $resource = $this->resource;
        $monedas = Moneda::all();
        return view('user.create', compact('resource', 'monedas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $data = $request->all();
        // $monedas = $request->input('monedas');
        // $splic = implode(',', $monedas);
        // dd($monedas,$splic,$data);
        $data['password'] = Hash::make($data['password']);
        $data['parent_id'] = auth()
        User::create($data);
        return redirect('/' . $this->resource);
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
        $user = User::find($id);
        $resource = $this->resource;
        $monedas = Moneda::all();
        return view('user.edit', compact('resource', 'monedas', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::find($id);
        $credenciales = $request->all();
        if (isset($credenciales['password'])) {
            $credenciales['password'] = bcrypt($request->password);
        } else {
            unset($credenciales['password']);
        }

        $user->update($credenciales);
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
