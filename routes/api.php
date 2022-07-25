<?php

use App\Http\Controllers\ResultController;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/send-results-complement', function (Request $request) {

    $data = $request->all();

    // return $data;
    $schedule = Schedule::where('id', $data['schedule_id'])->where('status', 0)->first();
    if ($schedule) {
        $response = ResultController::storeDirect($data['numero'], $data['schedule_id']);
        return response()->json(['valid', true], 200);
    } else {
        return response()->json(['valid', false], 200);
        // return ['sorteo realizado'];
    }

    // return $resultados;
    // return response()->json(['valid','response'],200);

});
