<?php

namespace App\Http\Controllers\Hipismo;

use App\Http\Controllers\Controller;
use App\Models\Hipismo\FixtureRace;
use App\Models\Hipismo\FixtureRaceHorse;
use Illuminate\Http\Request;

class FixtureRaceHorseController extends Controller
{
    public function show($race_id)
    {
        $race = FixtureRace::with('race')->find($race_id);
        $horses = FixtureRaceHorse::where('fixture_race_id', $race_id)->orderBy('horse_number','ASC')->get();
        return view('hipismo.ejemplares.show', compact('horses', 'race_id', 'race'));
    }
    public function save(Request $req)
    {
        try {
            $data = $req->all();
            foreach ($data as $key => $horse) {
                FixtureRaceHorse::createOrUpdate($horse);
            }
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
