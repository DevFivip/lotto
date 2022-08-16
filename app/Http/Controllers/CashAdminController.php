<?php

namespace App\Http\Controllers;

use App\Models\CashAdmin;
use App\Models\User;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;

class CashAdminController extends Controller
{

    public function __construct()
    {
        $this->resource = 'cash-admins';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = User::where('role_id', 2)->get();
        $resource = $this->resource;
        return view('cajaadmin.index', compact('admins', 'resource'));
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
    public function show(Request $request, $id)
    {


        $data = $request->all();

        if (!isset($data['fecha_inicio']) && !isset($data['fecha_fin'])) {
            $dt = new DateTime(date('Y-m-d H:i:s'), new DateTimeZone('UTC'));
            $dt->setTimezone(new DateTimeZone(session('timezone')));
            $cash = CashAdmin::where('admin_id', $id)->where('created_at', '>=', $dt->format('Y-m-d') . ' 00:00:00')->get();
        } else {
            if (!is_null($data['fecha_inicio']) && is_null($data['fecha_fin'])) {
                $cash = CashAdmin::where('admin_id', $id)
                    ->where('created_at', '>=', $data['fecha_inicio'] . ' 00:00:00')
                    ->where('created_at', '<=', $data['fecha_inicio'] . ' 23:59:59')->get();
            }

            if (!is_null($data['fecha_inicio']) && !is_null($data['fecha_fin'])) {
                $cash = CashAdmin::where('admin_id', $id)
                    ->where('created_at', '>=', $data['fecha_inicio'] . ' 00:00:00')
                    ->where('created_at', '<=', $data['fecha_fin'] . ' 23:59:59')->get();
            }
        }

        // $cash = CashAdmin::where('admin_id', $id)->created_at()->get();
        //
        $resource = $this->resource;
        return view('cajaadmin.show', compact('id', 'cash','resource'));
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
