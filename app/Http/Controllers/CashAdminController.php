<?php

namespace App\Http\Controllers;

use App\Models\CashAdmin;
use App\Models\Exchange;
use App\Models\Moneda;
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
    public function create(Request $request)
    {
        $data = $request->all();
        $admin_id = $data['admin_id'];
        $resource = $this->resource;
        $monedas = Moneda::whereIn('id', auth()->user()->monedas)->get();
        return view('cajaadmin.create', compact('resource', 'monedas', 'admin_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            //code...
            CashAdmin::create($request->all());
            return redirect('/' . $this->resource . '/' . $request->all()['admin_id']);
        } catch (\Throwable $th) {
            return redirect()->back();
        }
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
            $cash = CashAdmin::where('admin_id', $id)->where('created_at', '>=', $dt->format('Y-m-') . '01 00:00:00')->orderBy('created_at', 'DESC')->get();
        } else {
            if (!is_null($data['fecha_inicio']) && is_null($data['fecha_fin'])) {
                $cash = CashAdmin::where('admin_id', $id)
                    ->where('created_at', '>=', $data['fecha_inicio'] . ' 00:00:00')
                    ->where('created_at', '<=', $data['fecha_inicio'] . ' 23:59:59')->orderBy('created_at', 'DESC')->get();
            }

            if (!is_null($data['fecha_inicio']) && !is_null($data['fecha_fin'])) {
                $cash = CashAdmin::where('admin_id', $id)
                    ->where('created_at', '>=', $data['fecha_inicio'] . ' 00:00:00')
                    ->where('created_at', '<=', $data['fecha_fin'] . ' 23:59:59')->orderBy('created_at', 'DESC')->get();
            }
        }


        $monedas = $cash->groupBy('moneda_id');

        $total = $monedas->map(function ($moneda_group, $moneda_id) {
            $ingresos =  $moneda_group->sum(function ($gr) {
                if ($gr->type == 1) {
                    return $gr->total;
                }
            });

            $egresos =  $moneda_group->sum(function ($gr) {
                if ($gr->type == -1) {
                    return $gr->total;
                }
            });

            $moneda = Moneda::find($moneda_id);
            $exchange = Exchange::where('moneda_id', $moneda_id)->first();
            $total = $ingresos - $egresos;
            $change = $total / $exchange->change_usd;
            return ['moneda' => $moneda, 'ingresos' => $ingresos, 'egresos' => $egresos, 'total' => $total, 'change' => $change];
        });

        $total_exchange = 0;
        foreach ($total as $res) {
            $total_exchange += $res['change'];
        }
        // $cash = CashAdmin::where('admin_id', $id)->created_at()->get();
        //
        $resource = $this->resource;
        return view('cajaadmin.show', compact('id', 'cash', 'resource', 'total', 'total_exchange', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cash = CashAdmin::find($id);
        $resource = $this->resource;
        $monedas = Moneda::whereIn('id', auth()->user()->monedas)->get();
        return view('cajaadmin.edit', compact('resource', 'monedas', 'cash'));
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

        try {
            $cash = CashAdmin::find($id);
            $data = $request->all();
            $data['created_at'] = new DateTime($data['created_at'] . " 08:00:00", new DateTimeZone(session('timezone')));;
            $cash->update($data);
            $cash->save();
            return redirect('/' . $this->resource . '/' . $request->all()['admin_id']);
        } catch (\Throwable $th) {
            return redirect()->back();
        }
        // dd($request->all());
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
