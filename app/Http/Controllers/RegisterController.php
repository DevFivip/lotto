<?php

namespace App\Http\Controllers;

use App\Models\Register;
use Illuminate\Http\Request;

class RegisterController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        // ver todos si eres el super admin

        if (auth()->user()->role_id === 1) {
            $tickets = Register::all();
        } elseif (auth()->user()->role_id === 2) {
            $tickets = Register::where('admin_id', auth()->user()->id)->get();
        } elseif (auth()->user()->role_id === 3) {
            $padre = auth()->user()->parent_id;
            $tickets = Register::where('admin_id', $padre)->get();
        }

        return view('tickets.listado', compact('tickets'));

        //


    }


    public function create(Request $request)
    {
        //
        return response()->json(["valid" => true]);
    }




    public function destroy()
    {
        //
    }
}
