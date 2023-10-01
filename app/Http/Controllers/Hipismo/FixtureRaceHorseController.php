<?php

namespace App\Http\Controllers\Hipismo;

use App\Http\Controllers\Controller;
use App\Models\Hipismo\FixtureRace;
use App\Models\Hipismo\FixtureRaceHorse;
use App\Models\Hipismo\HipismoBancaResultado;
use Illuminate\Http\Request;

class FixtureRaceHorseController extends Controller
{
    public function show($race_id)
    {
        $admin_id = null;

        if (auth()->user()->role_id == 1) {
            $admin_id = auth()->user()->parent_id;
        }

        if (auth()->user()->role_id == 2) {
            $admin_id = auth()->user()->id;
        }

        $race = FixtureRace::with('race')->find($race_id);
        $resultados = HipismoBancaResultado::where('admin_id', $admin_id)->where('fixture_race_id', $race_id)->get();
        $horses = FixtureRaceHorse::where('fixture_race_id', $race_id)->orderBy('horse_number', 'ASC')->get();
        return view('hipismo.ejemplares.show', compact('horses', 'race_id', 'race', 'resultados'));
    }

    public function combinacionsave(Request $req, $race_id)
    {
        try {
            $data = $req->all();
            // buscar
            if (auth()->user()->role_id == 2) {
                $ganador = HipismoBancaResultado::where('admin_id', auth()->user()->id)->where('fixture_race_id', $race_id)->where('apuesta_type', 1)->first();
                if ($ganador == null) {
                    //?create
                    $res = HipismoBancaResultado::create([
                        "admin_id" => auth()->user()->id,
                        "fixture_race_id" => $race_id,
                        "apuesta_type" => 1,
                        "combinacion" => $data['ganador']['combinacion'],
                        "win" => $data['ganador']['total']
                    ]);
                } else {
                    //?update
                    $ganador->combinacion =  $data['ganador']['combinacion'];
                    $ganador->win = $data['ganador']['total'];
                    $ganador->update();
                }

                $perfecta = HipismoBancaResultado::where('admin_id', auth()->user()->id)->where('fixture_race_id', $race_id)->where('apuesta_type', 2)->first();
                if ($perfecta == null) {
                    $res = HipismoBancaResultado::create([
                        "admin_id" => auth()->user()->id,
                        "fixture_race_id" => $race_id,
                        "apuesta_type" => 2,
                        "combinacion" => $data['perfecta']['combinacion'],
                        "win" => $data['perfecta']['total']
                    ]);
                } else {
                    $perfecta->combinacion =  $data['perfecta']['combinacion'];
                    $perfecta->win =  $data['perfecta']['total'];
                    $perfecta->update();
                }

                $trifecta = HipismoBancaResultado::where('admin_id', auth()->user()->id)->where('fixture_race_id', $race_id)->where('apuesta_type', 3)->first();
                if ($trifecta == null) {
                    $res = HipismoBancaResultado::create([
                        "admin_id" => auth()->user()->id,
                        "fixture_race_id" => $race_id,
                        "apuesta_type" => 3,
                        "combinacion" => $data['trifecta']['combinacion'],
                        "win" => $data['trifecta']['total']
                    ]);
                } else {
                    $trifecta->combinacion =  $data['trifecta']['combinacion'];
                    $trifecta->win =  $data['trifecta']['total'];
                    $trifecta->update();
                }
            } else {
                return response()->json(['valid' => false, 'message' => 'Solo los Administradores pueden los resultados'], 400);
            }

            // RESULTADOS DE LA BANCA
            //GANADOR
            return response()->json(['valid' => true, 'message' => 'Resultados Guardados']);
        } catch (\Throwable $th) {
            return response()->json(['valid' => false, 'message' => $th->getMessage()], 400);
        }
    }

    public function save(Request $req)
    {
        try {
            $data = $req->all();
            foreach ($data as $key => $horse) {
                FixtureRaceHorse::createOrUpdate($horse);
            }
            // RESULTADOS DE LA BANCA
            //GANADOR
            return response()->json(['valid' => true, 'message' => 'Ejemplares Guardados']);
        } catch (\Throwable $th) {
            return response()->json(['valid' => false, 'message' => $th->getMessage()], 402);
        }
    }

    public function disable($horse_id)
    {
        $horse = FixtureRaceHorse::find($horse_id);
        $horse->status =  !$horse->status;
        $horse->update();
        return response()->json(['valid' => true, 'message' => 'actualizado']);
    }

    public function remateWinner($horse_id)
    {
        $horse = FixtureRaceHorse::find($horse_id);
        $horse->remate_winner =  !$horse->remate_winner;
        $horse->update();
        return response()->json(['valid' => true, 'message' => 'actualizado']);
    }

    public function delete($horse_id)
    {
        try {
            $horse = FixtureRaceHorse::find($horse_id);
            $horse->delete();
        } catch (\Throwable $th) {
            return response()->json(['valid' => false, 'message' => $th->getMessage()]);
        }
        return response()->json(['valid' => true, 'message' => 'Eliminado']);
    }
    public function get($race_id)
    {

        try {
            $horses = FixtureRaceHorse::where('fixture_race_id', $race_id)->orderBy('horse_number', 'ASC')->get();
        } catch (\Throwable $th) {
            return response()->json([
                "valid" => true,
                "message" => $th->getMessage(),
            ]);
        }

        return response()->json([
            "valid" => true,
            "message" => 'horses success',
            "data" => $horses,
        ]);
    }
}
