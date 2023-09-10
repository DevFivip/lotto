<?php

namespace App\Http\Controllers\Hipismo;

use App\Http\Controllers\Controller;
use App\Models\Hipismo\FixtureRace;
use Illuminate\Http\Request;

class FixtureRaceController extends Controller
{
    public function save(Request $request)
    {
        try {
            $data = $request->all();
            foreach ($data as $k => $fixture) {
                FixtureRace::createOrUpdate($fixture);
            }
            return response()->json([
                'valid' => true,
                'message' => 'Guardado correctamente'
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'valid' => false,
                'message' => $th->getMessage()
            ], 402);
        }
    }

    public function delete($id)
    {
        try {
            $fixture =  FixtureRace::find($id);
            $fixture->delete();
            return response()->json([
                'valid' => true,
                'message' => 'Eliminado correctamente'
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'valid' => false,
                'message' => $th->getMessage()
            ], 402);
        }
    }
}
