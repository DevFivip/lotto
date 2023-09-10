<?php

namespace App\Http\Controllers\Hipismo;

use App\Http\Controllers\Controller;
use App\Models\Hipismo\FixtureRace;
use App\Models\Hipismo\Race;
use App\Models\Hipismo\FixtureRaceHorse;
use App\Models\Hipismo\HipismoRemate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaquillaController extends Controller
{
    //

    public function create()
    {

        $date = date('Y-m-d H:i:s');
        $comming_races = FixtureRace::with('hipodromo', 'race')->where('start_time', '>=', $date)->get();
        // $horses = FixtureRaceHorse::where('fixture_race_id', $race_id)->get();
        return view('hipismo.taquilla.create', compact('comming_races'));
    }

    public function rematesave(Request $req)
    {
        try {
            $uuid = uniqid();
            $data = $req->all();

            foreach ($data as $k => $horses) {
                HipismoRemate::createOrUpdate($horses, $uuid);
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
            $data = HipismoRemate::with('horse',)->where([
                'code' => $code
            ])->get();
        } catch (\Throwable $th) {
            return response()->json(['valid' => true, 'message' => $th->getMessage()]);
        }

        return response()->json(['valid' => true, 'message' => 'success', "data" => $data]);
    }

    public function dashboard()
    {
        $totals = HipismoRemate::where('monto', ">", 0.1)->groupBy('moneda_id')->sum('monto');
        $premios = $totals * 0.70;
        $banca = $totals * 0.30;

        $remates = HipismoRemate::where('monto', ">", 0.1)->paginate();
        return view('hipismo.dashboard', compact('remates', 'totals', 'banca', 'premios'));
    }
}
