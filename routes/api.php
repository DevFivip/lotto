<?php

use App\Http\Controllers\ResultController;
use App\Models\RegisterDetail;
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
    $schedule = Schedule::where('sorteo_type_id', 1)->where('status', 0)->first();

    // $output = new \Symfony\Component\Console\Output\ConsoleOutput();
    // $output->writeln("<info>$schedule</info>");
    if ($schedule) {
        $response = ResultController::storeDirectGeneric($data['numero'], $data['schedule_id'], 1);

        // dd($response);
        return response()->json($response, 200);
    } else {
        return response()->json(['valid' => false], 200);
        // return ['sorteo realizado'];
    }

    // return $resultados;
    // return response()->json(['valid','response'],200);

})->middleware('rate_limit');;

Route::post('/send-results-granjita', function (Request $request) {
    $data = $request->all();
    $schedule = Schedule::where('status', 0)->where('sorteo_type_id', 2)->first();
    // $output = new \Symfony\Component\Console\Output\ConsoleOutput();
    // $output->writeln("<info>$schedule</info>");
    if ($schedule) {
        $response = ResultController::storeDirectGeneric2($data['numero'], $data['schedule_id']-1, 2);
        return response()->json($response, 200);
    } else {
        return response()->json(['valid' => false], 200);
    }
})->middleware('rate_limit');

Route::post('/send-results-selvaParaiso', function (Request $request) {

    $data = $request->all();
    $schedule = Schedule::where('status', 0)->where('sorteo_type_id', 3)->first();
    if ($schedule) {
        $response = ResultController::storeDirectGeneric2($data['numero'], $data['schedule_id'], 3);
        return response()->json($response, 200);
    } else {
        return response()->json(['valid' => false], 200);
    }
})->middleware('rate_limit');;

Route::post('/send-results-lottoactivo', function (Request $request) {

    $data = $request->all();
    $schedule = Schedule::where('status', 0)->where('sorteo_type_id', 1)->first(); //cambiar en producction

    if ($schedule) {
        $response = ResultController::storeDirectGeneric2($data['numero'], $data['schedule_id'], 1);
        return response()->json($response, 200);

        return response()->json(['valid' => false], 200);
    } else {
        return response()->json(['valid' => false], 200);
    }
})->middleware('rate_limit');;

Route::post('/send-results-lottoactivord', function (Request $request) {

    $data = $request->all();
    $schedule = Schedule::where('status', 0)->where('sorteo_type_id', 5)->first(); //cambiar en producction

    if ($schedule) {
        $response = ResultController::storeDirectGeneric2($data['numero'], $data['schedule_id'], 5);
        return response()->json($response, 200);
    } else {
        return response()->json(['valid' => false], 200);
    }
})->middleware('rate_limit');;

Route::post('/send-results-lottorey', function (Request $request) {
    $data = $request->all();
    $schedule = Schedule::where('status', 0)->where('sorteo_type_id', 6)->first();
    // $output = new \Symfony\Component\Console\Output\ConsoleOutput();
    // $output->writeln("<info>$data</info>");
    if ($schedule) {
        $response = ResultController::storeDirectGeneric2($data['numero'], $data['schedule_id'], 6);
        return response()->json($response, 200);
    } else {
        return response()->json(['valid' => false], 200);
    }
})->middleware('rate_limit');;

Route::post('/send-results-chanceanimalitos', function (Request $request) {

    $data = $request->all();
    $schedule = Schedule::where('status', 0)->where('sorteo_type_id', 7)->first();
    if ($schedule) {
        $response = ResultController::storeDirectGeneric($data['numero'], $data['schedule_id'], 7);
        return response()->json($response, 200);
    } else {
        return response()->json(['valid' => false], 200);
    }
})->middleware('rate_limit');;

Route::post('/send-results-selvaplus', function (Request $request) {

    $data = $request->all();
    $schedule = Schedule::where('status', 0)->where('sorteo_type_id', 11)->first();
    if ($schedule) {
        $response = ResultController::storeDirectGeneric($data['numero'], $data['schedule_id'], 11);
        return response()->json($response, 200);
    } else {
        return response()->json(['valid' => false], 200);
    }
})->middleware('rate_limit');;

Route::post('/send-results-tropigana', function (Request $request) {

    $data = $request->all();
    $schedule = Schedule::where('status', 0)->where('sorteo_type_id', 8)->first();
    // $output = new \Symfony\Component\Console\Output\ConsoleOutput();
    // $output->writeln("<info>$schedule</info>");
    if ($schedule) {
        $response = ResultController::storeDirectGeneric($data['numero'], $data['schedule_id'], 8);
        return response()->json($response, 200);
    } else {
        return response()->json(['valid' => false], 200);
    }
})->middleware('rate_limit');;

Route::post('/send-results-junglamillonaria', function (Request $request) {
    $data = $request->all();
    $schedule = Schedule::where('status', 0)->where('sorteo_type_id', 9)->first();
    if ($schedule) {
        $response = ResultController::storeDirectGeneric($data['numero'], $data['schedule_id'], 9);
        return response()->json($response, 200);
    } else {
        return response()->json(['valid' => false], 200);
    }
})->middleware('rate_limit');;

Route::post('/send-results-ruletaactiva', function (Request $request) {
    $data = $request->all();
    $schedule = Schedule::where('status', 0)->where('sorteo_type_id', 12)->first();
    if ($schedule) {
        $response = ResultController::storeDirectGeneric($data['numero'], $data['schedule_id'], 12);
        return response()->json($response, 200);
    } else {
        return response()->json(['valid' => false], 200);
    }
})->middleware('rate_limit');;

Route::post('/send-results-guacharo', function (Request $request) {
    $data = $request->all();
    $schedule = Schedule::where('status', 0)->where('sorteo_type_id', 10)->first();
    if ($schedule) {
        $response = ResultController::storeDirectGeneric($data['numero'], $data['schedule_id'], 10);
        return response()->json($response, 200);
    } else {
        return response()->json(['valid' => false], 200);
    }
})->middleware('rate_limit');;



Route::post('/save_soteo_semanal', function (Request $request) {
    $data = $request->all();
});
