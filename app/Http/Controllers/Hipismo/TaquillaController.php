<?php

namespace App\Http\Controllers\Hipismo;

use App\Http\Controllers\Controller;
use App\Models\Hipismo\FixtureRace;
use App\Models\Hipismo\Race;
use App\Models\Hipismo\FixtureRaceHorse;
use App\Models\Hipismo\HipismoRemate;
use App\Models\Hipismo\HipismoRemateHead;
use App\Models\Hipismo\Hipodromo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaquillaController extends Controller
{
    //

    public function create()
    {

        $date = date('Y-m-d H:i:s');
        $comming_races = FixtureRace::with('hipodromo', 'race')->where('start_time', '>=', $date)->get();
        // dd( $date,$comming_races);
        // $horses = FixtureRaceHorse::where('fixture_race_id', $race_id)->get();
        return view('hipismo.taquilla.create', compact('comming_races'));
    }

    public function banca()
    {
        $hipodromos = Hipodromo::where('status', 1)->get();
        return view('hipismo.taquilla.banca', compact('hipodromos'));
    }

    public function getCommingRaces($hipodromo_id)
    {
        $date = date('Y-m-d');
        $comming_races = Race::with('hipodromo', 'fixtures')->where('hipodromo_id', $hipodromo_id)->where('race_day', '>=', $date . " 00:00:00")->get();

        return response()->json([
            "valid" => true,
            "data" => $comming_races,
            "message" => "success"
        ]);
    }

    public function rematesave(Request $req)
    {
        try {
            $uuid = uniqid();
            $data = $req->all();
            // dd($data);
            if (isset($data['remateHorses'][0]['code'])) {
                // dd($data);
                //? UPDATE
                $rem = HipismoRemateHead::find($data['remateHorses'][0]['hipismo_remate_head_id']);
                $rem->total = $data['total'];
                $rem->pagado = $data['premio'];
                $rem->save();
            } else {
                //? CREATE
                $rem = HipismoRemateHead::create([
                    'total' => $data['total'],
                    'pagado' => $data['premio'],
                    'user_id' => auth()->user()->id,
                    'admin_id' => auth()->user()->parent_id,
                    'fixture_race_id' => $data['remateHorses'][0]['fixture_race_id'],
                ]);
            }

            foreach ($data['remateHorses'] as $k => $horses) {
                HipismoRemate::createOrUpdate($horses, $uuid, $rem->id);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'valid' => false,
                'message' => $th->getMessage()
            ], 402);
        }

        return response()->json([
            'valid' => true,
            'message' => 'Guardado correctamente'
        ], 200);
    }
    public function getRemateCodes($fixture_race_id)
    {
        try {
            $auth = Auth::user();
            $data = HipismoRemate::select('code')->where([
                'fixture_race_id' => $fixture_race_id,
                'user_id' => $auth->id,
                'admin_id' => $auth->parent_id,
            ])->groupBy('code')->get();
        } catch (\Throwable $th) {
            return response()->json(['valid' => true, 'message' => $th->getMessage()]);
        }

        return response()->json(['valid' => true, 'message' => 'success', "data" => $data]);
    }

    public function remateView($code)
    {
        try {
            $data = HipismoRemate::with('horse')->where([
                'code' => $code
            ])->get();
        } catch (\Throwable $th) {
            return response()->json(['valid' => true, 'message' => $th->getMessage()]);
        }

        return response()->json(['valid' => true, 'message' => 'success', "data" => $data]);
    }
    public function remateEdit($code)
    {
        try {
            $detalles = HipismoRemate::with('horse')->where([
                'code' => $code
            ])->get();
            $remate = HipismoRemateHead::where([
                'id' => $detalles[0]->hipismo_remate_head_id
            ])->first();
        } catch (\Throwable $th) {
            return response()->json(['valid' => true, 'message' => $th->getMessage()]);
        }

        return view('hipismo.taquilla.edit', compact('detalles', 'remate'));
        // return response()->json(['valid' => true, 'message' => 'success', "data" => $data]);
    }

    public function dashboard()
    {
        $date = date('Y-m-d');
        // dd();
        $hipodromos = Hipodromo::with(["races" => function ($race) use ($date) {
            $race->where('race_day', '>=', $date . " 00:00:00")->with(['fixtures' => function ($fixture) {
                return $fixture->with(['remates' => function ($rem) {
                    return $rem->where('user_id', auth()->user()->id)->with(['remates' => function ($odd) {
                        return $odd->with(['horse'])->get();
                    }])->get();
                }])->get();
            }])->get();
        }])->get();

        //  dd($hipodromos->toArray());
        // $races = Race::with(['fixtures'=>function($q){return $q->with('asd');}])->where('race_day', '>=', $date . " 00:00:00")->get();
        // dd($races);
        $remates = HipismoRemate::with(['horse'])->where('user_id', auth()->user()->id)->where('created_at',  '>=', $date . " 00:00:00")->get();
        $totals = HipismoRemateHead::where('user_id', auth()->user()->id)->where('created_at',  '>=', $date . " 00:00:00")->get();
        // dd($remates);

        $_remates = $remates->filter(function ($v, $k) {
            if ($v->horse->status == 1) {
                return $v;
            }
        });
        // dd($_remates);


        $total = $_remates->sum('monto');
        $pagado = $totals->sum('pagado');

        //  dd($total,$pagado);


        $remates = HipismoRemate::where('monto', ">", 0.1)->paginate();
        return view('hipismo.dashboard', compact('remates', 'total', 'pagado', 'hipodromos'));
    }
}
