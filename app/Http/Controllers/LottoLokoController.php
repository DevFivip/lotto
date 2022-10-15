<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\LottoPlusConfig;
use App\Models\NextResult;
use App\Models\RegisterDetail;
use App\Models\Schedule;
use App\Models\User;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;

class LottoLokoController extends Controller
{

    public function preview()
    {
        // horario is_send no enviado  =  0
        // el ultimo que no se a enviado

        $setting = LottoPlusConfig::first();

        $horario = schedule::where('is_send', 0)->where('sorteo_type_id', 4)->orderBy('id', 'ASC')->first();
        // dd($horario->schedule);
        //obtener socios 
        $socios = User::where('is_socio', 1)->get();

        $so = [];

        for ($h = 0; $h < $socios->count(); $h++) {
            array_push($so, $socios[$h]['id']);
        }

        // array_push($so, auth()->user()->id);

        // dd($so);

        $dt = new DateTime(date('Y-m-d H:i:s'), new DateTimeZone('UTC'));
        $dt->setTimezone(new DateTimeZone('America/Caracas'));

        // dd($dt);

        $details = RegisterDetail::with(['animal', 'exchange'])
            ->whereIn('admin_id', $so)
            ->where('schedule_id', $horario->id)
            ->where("sorteo_type_id", 4)
            ->where("status", 0)
            ->where("created_at", ">=", $dt->format("Y-m-d") . " 00:00:01")
            // ->where("created_at", "<=", $dt->format("Y-m-d") . " 23:00:00")
            ->get();
        // dd($details );

        $grupo_animalito = $details->groupBy('animal_id');

        $hh =  $grupo_animalito->map(function ($v, $k) {
            $data = [];
            $data['animal_id'] = $v[0]->animal->id;
            $data['animal'] = $v[0]->animal->nombre;
            $data['animal_numero'] = $v[0]->animal->number;
            $data['total_jugadas'] = $v->count();
            $data['total_monto_usd'] = $v->sum(function ($a) {
                return ($a->monto / $a->exchange->change_usd);
            });

            $data['total_recompensa_usd'] = $v->sum(function ($a) {
                return (($a->monto * 32) / $a->exchange->change_usd);
            });

            // dd($v);
            return $data;
        });

        $selected_animales_ids = [];

        foreach ($hh as $hhh) {
            array_push($selected_animales_ids, $hhh['animal_numero']);
        }


        $complete_animal = Animal::select('id', 'nombre', 'number')->where('sorteo_type_id', 4,)->whereNotIn('number', $selected_animales_ids)->get();

        foreach ($complete_animal as $compl) {
            $data = [];
            $data['animal_id'] = $compl->id;
            $data['animal'] = $compl->nombre;
            $data['animal_numero'] = $compl->number;
            $data['total_jugadas']  = 0;
            $data['total_monto_usd'] = 0;
            $data['total_recompensa_usd'] = 0;
            $hh->push($data);
        }

        $totales = [];
        $totales['total_jugadas'] = $details->count();
        $totales['total_venta_usd'] = 0;
        $totales['total_caja_usd'] = 0;
        $totales['total_comision_usd'] = 0;
        $totales['balance_80'] = 0; // maximo en premios que se repartiran

        foreach ($details as $detail) {
            $totales['total_venta_usd'] += $detail->monto / $detail->exchange->change_usd;
            $totales['total_comision_usd'] += ($detail->monto *  $setting->porcent_comision) / $detail->exchange->change_usd;
            $totales['balance_80'] += ($detail->monto * $setting->porcent_limit) / $detail->exchange->change_usd;
            $totales['total_caja_usd'] += ($detail->monto * $setting->porcent_cash) / $detail->exchange->change_usd;
        }

        // dd($totales);
        $hh = $hh->sortBy(
            [
                ['total_recompensa_usd', 'desc'],
                ['total_jugadas', 'desc'],
            ]
        );
        /**
         * 
         * FILTRAR DEFAULT; RECOGER Y PREMIAR
         */

        /*
        *Default
        */
        $arr_bas = $hh->filter(function ($v, $k) use ($totales) {
            if ($v['total_recompensa_usd'] < $totales['balance_80']) {
                return $v;
            }
        });


        /*
        *Premiar
        */
        $premiar = [];
        $premiar[] = $hh->sortByDesc('total_recompensa_usd')->first();
        $premiar[] = $hh->sortByDesc('total_jugadas')->first();

        /*
        *Recoger
        */
        $recoger = [];
        $recoger[] = $hh->sortBy('total_recompensa_usd')->first();
        $recoger[] = $hh->sortBy('total_jugadas')->first();


        // dd($recoger);
        // dd($arr_premiar);

        $default = $arr_bas->first();

        // dd($arr_premiar);

        $next = NextResult::with('animal')->first();

        return view("lottoloko.preview", compact('hh', 'totales', 'horario', 'default', 'premiar', 'recoger', 'next','setting'));
    }

    public function animalitos()
    {
        $animals = Animal::with('type')->where('sorteo_type_id', 4)->get();
        $resource = 'animals';
        return view('animals.index', compact('animals', 'resource'));
    }

    public function horarios()
    {
        $schedules = Schedule::where('sorteo_type_id', 4)->get();
        $resource = 'schedules';
        return view('schedules.index', compact('schedules', 'resource'));
    }

    function save(Request $request)
    {

        $data = $request->all();
        // dd($data);
        $next = NextResult::first();

        if ($next == null) {
            $nr = new NextResult();
            $nr->animal_id = $data['animalito'];
            $nr->schedule = $data['schedule'];
            $nr->save();
            return redirect()->back()->withInput(['message' => "saved"]);
        } else {
            $next->animal_id = $data['animalito'];
            $next->schedule = $data['schedule'];
            $next->update();
            return redirect()->back()->withInput(['message' => "saved"]);
        }

        return redirect()->back()->withErrors(['message' => "saved"])->withInput();
    }


    function settings()
    {
        if (auth()->user()->role_id != 1) {
            return redirect()->back()->withErrors(['message' => "error"])->withInput();
        }

        $setting = LottoPlusConfig::first();
        return view('lottoloko.settings', compact('setting'));
    }
    function setSettings(Request $request)
    {

        $data = $request->all();

        $setting = LottoPlusConfig::first();
        $setting->porcent_comision = $data['porcent_comision'];
        $setting->porcent_cash = $data['porcent_cash'];
        $setting->porcent_limit = $data['porcent_limit'];
        $setting->update();

        return redirect('/lottoloko/')->withErrors(['message' => "saved"])->withInput();
    }
}
