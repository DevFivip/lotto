<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportControllers extends Controller
{
    //

    public function index(Request $request)
    {
        return view('reports.index');
    }

    public function query(Request $request)
    {
    }
}
