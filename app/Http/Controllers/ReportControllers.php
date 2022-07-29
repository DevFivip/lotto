<?php

namespace App\Http\Controllers;

use App\Models\Moneda;
use App\Models\RegisterDetail;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ReportControllers extends Controller
{
    //

    public function index(Request $request)
    {
        return view('reports.index');
    }

    public function general(Request $request)
    {

        $data  = $request->all();

        $fecha_inicio = isset($data['fecha_inicio']) ? $data['fecha_inicio'] : null;
        $fecha_fin = isset($data['fecha_fin']) ? $data['fecha_fin'] : null;

        $registersdetails = new RegisterDetail;

        if (auth()->user()->role_id == 2) {

            $registersdetails = $registersdetails->where('admin_id', auth()->user()->id);
        }

        if (auth()->user()->role_id == 3) {
            $registersdetails = $registersdetails->where('user_id', auth()->user()->id);
        }

        if ($fecha_inicio) {
            $registersdetails = $registersdetails->where('created_at', '>=', $fecha_inicio  . ' 00:00:00');
        }

        if ($fecha_fin) {
            $registersdetails = $registersdetails->where('created_at', '<=', $fecha_fin . ' 23:59:59');
        }

        // dd($registersdetails->toSql());

        $r = $registersdetails->get();

        $group = $r->groupBy('schedule_id');

        $fff =  $group->map(function ($v, $q) {

            $moneda = $v->groupBy('moneda_id');
            $_moneda = $moneda->map(function ($h, $k) {
                $m = Moneda::find($k);
                $monto = $h->sum('monto');
                $premios = $h->sum(function ($p) {
                    if ($p->winner == 1) {
                        return $p->monto * 30;
                    }
                });
                return [$m->currency, $m->simbolo, $monto, $h->count(), $monto * 0.13, $premios];
            });
            $schedule = Schedule::find($q);
            $_moneda['sorteo'] = $schedule->schedule;
            return $_moneda;
        });

        $datas =  $fff;
        return view('reports.general', compact('datas'));
    }

    public function query(Request $request)
    {
    }

    public function personalStarts(Request $request)
    {
        $data = $request->all();
        $user_id = $data['user_id'];
    }
}
