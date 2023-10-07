<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\CajaController;
use App\Http\Controllers\CajaRegisterController;
use App\Http\Controllers\CashAdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Hipismo\RaceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\QuinelaController;
use App\Http\Controllers\QuinelaRegisterController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SorteosController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TripletaController;
use App\Http\Controllers\UserController;
use App\Jobs\BuscarFiltracion;
use App\Models\Result;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/home');
});


Route::get('/test', function () {
    BuscarFiltracion::dispatchAfterResponse();
    return response('FIN');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController2::class, 'index'])->name('home');

Route::middleware('verifyUserStatus')->group(function () {
    Route::resource('/usuarios', UserController::class);
    Route::resource('/cajas', CajaController::class);
    Route::resource('/caja-registers', CajaRegisterController::class);
    Route::resource('/tickets', TicketController::class);
    Route::resource('/tripletas', TripletaController::class);
    Route::resource('/animals', AnimalController::class);
    Route::resource('/customers', CustomerController::class);
    Route::resource('/payments', PaymentController::class);
    Route::resource('/schedules', ScheduleController::class);

    //! disable mientras termino hipismo modulo 
    // Route::resource('/quinelas-maker', QuinelaController::class);
    // Route::get('/quinelas/select', [QuinelaRegisterController::class, 'select']);
    // Route::get('/quinelas/create_new/{id}', [QuinelaRegisterController::class, 'create_new']);
    // Route::resource('/quinelas', QuinelaRegisterController::class);

    Route::resource('/resultados', ResultController::class);
    Route::resource('/cash-admins', CashAdminController::class);
    Route::resource('/sorteos', SorteosController::class);
    Route::post('/sorteos/{id}/crear-limites', [App\Http\Controllers\SorteosController::class, 'limitesSettings']);

    Route::get('/tripletas/print/{code}', [App\Http\Controllers\TripletaController::class, 'print']);
    Route::get('/tripletas/pay/{code}', [App\Http\Controllers\TripletaController::class, 'pay']);
    Route::delete('/tripletas/delete/{code}/{codigo_eliminacion}', [App\Http\Controllers\TripletaController::class, 'eliminar']);


    Route::get('/chart', [App\Http\Controllers\JugadasController::class, 'plays']);
    Route::get('/chart/detail', [App\Http\Controllers\JugadasController::class, 'detail']);
    Route::get('/choose', [App\Http\Controllers\JugadasController::class, 'choose']);
    Route::get('/schedules/{schedule_id}/limits', [App\Http\Controllers\ScheduleController::class, 'limits']);
    Route::post('/schedules/save', [App\Http\Controllers\ScheduleController::class, 'limits_save']);


    Route::get('/tickets-repeat', [App\Http\Controllers\TicketController::class, 'repeat']);
    Route::get('/POS', [App\Http\Controllers\TicketController::class, 'POS']);

    // Route::get('/bingo/create', [App\Http\Controllers\BingoController::class, 'create'])->name('bingo.create');
    // Route::post('/bingo/store', [App\Http\Controllers\BingoController::class, 'store'])->name('bingo.store');
    // Route::get('/bingo', [App\Http\Controllers\BingoController::class, 'index'])->name('bingo.index');
    // Route::get('/bingo/transferir-creditos', [App\Http\Controllers\BingoController::class, 'transferirCreditos'])->name('bingo.transferircreditos');
    // Route::get('/bingo/print', [App\Http\Controllers\BingoController::class, 'print']);
    // Route::delete('/bingo', [App\Http\Controllers\BingoController::class, 'destroy']);


    Route::post('/tickets/makepay/{id}', [App\Http\Controllers\RegisterController::class, 'payAnimalito']);
    Route::get('/tickets/pay/{code}', [App\Http\Controllers\TicketController::class, 'pay']);
    Route::post('/ticket-register', [App\Http\Controllers\RegisterController::class, 'create']);
    Route::post('/ticket-validate/{code}', [App\Http\Controllers\TicketController::class, 'validateToPay']);
    Route::get('/print-direct/{code}', [App\Http\Controllers\RegisterController::class, 'print_direct']);
    Route::get('/print/{code}', [App\Http\Controllers\RegisterController::class, 'print']);
});

// Route::get('/wallets', [App\Http\Controllers\WalletController::class, 'index'])->name('wallets.index');
// Route::get('/wallets/create', [App\Http\Controllers\WalletController::class, 'create'])->name('wallets.create');
// Route::post('/wallets', [App\Http\Controllers\WalletController::class, 'store'])->name('wallets.store');

// Route::get('/wallets/transferencia-bingo-coin', [App\Http\Controllers\WalletController::class, 'bingoCoin'])->name('wallets.bCoin');


Route::get('/print2/{code}', [App\Http\Controllers\RegisterController::class, 'print2']);
Route::get('/report-caja/{id}', [App\Http\Controllers\CajaController::class, 'report']);
Route::get('/balance-caja/{id}', [App\Http\Controllers\CajaController::class, 'show']);
Route::get('/add-balance-caja/{id}', [App\Http\Controllers\CajaController::class, 'addBalance']);
Route::post('/cash-flow/{id}', [App\Http\Controllers\CajaController::class, 'cashFlow']);
Route::get('/reports', [App\Http\Controllers\ReportControllers::class, 'index']);
Route::get('/reports/general', [App\Http\Controllers\ReportControllers::class, 'general']);
Route::get('/reports/usuario', [App\Http\Controllers\ReportControllers::class, 'personalStarts']);

Route::get('/lottoloko', [App\Http\Controllers\LottoLokoController::class, 'preview']);
Route::get('/lottoloko/animalitos', [App\Http\Controllers\LottoLokoController::class, 'animalitos']);
Route::get('/lottoloko/horarios', [App\Http\Controllers\LottoLokoController::class, 'horarios']);
Route::post('/lottoloko/save', [App\Http\Controllers\LottoLokoController::class, 'save']);
Route::get('/lottoloko/setting', [App\Http\Controllers\LottoLokoController::class, 'settings']);
Route::put('/lottoloko/setSetting', [App\Http\Controllers\LottoLokoController::class, 'setSettings']);

Route::get('/setting-impresora', function () {
    return view('setting.impresora');
});

Route::delete('/register/{code}', [App\Http\Controllers\RegisterController::class, 'destroy']);
Route::delete('/register/delete/{code}/{codigo_eliminacion}', [App\Http\Controllers\RegisterController::class, 'eliminar']);

// Route::get('/scrap', [App\Http\Controllers\ScrappingController::class, 'scrap']);
// Route::post('/send-results-complement', [App\Http\Controllers\ScrappingController::class, 'getResult']);

Route::get('/schedules-admin', [App\Http\Controllers\UserAnimalitoScheduleController::class, 'index']);
Route::get('/schedules-admin/{id}/limits', [App\Http\Controllers\UserAnimalitoScheduleController::class, 'edit']);
Route::post('/schedules-admin/save', [App\Http\Controllers\UserAnimalitoScheduleController::class, 'update']);

//! disable mientras termino hipismo modulo 
// Route::prefix('clientes')->group(function () {
//     Route::get('/auth', [App\Http\Controllers\CustomerZone\CustomerZoneController::class, 'auth']);
//     Route::post('/auth', [App\Http\Controllers\CustomerZone\CustomerZoneController::class, 'login']);
//     Route::get('/dashboard', [App\Http\Controllers\CustomerZone\CustomerZoneController::class, 'dashboard']);
//     Route::get('/quinelas/{quinela_id}', [App\Http\Controllers\CustomerZone\QuinelaController::class, 'index']);
// });


Route::prefix('hipismo')->group(function () {
    Route::get('/hipodromos', [App\Http\Controllers\Hipismo\HipodromoController::class, 'index'])->name('hipismo.hipodromos.index');
    Route::get('/hipodromos/create', [App\Http\Controllers\Hipismo\HipodromoController::class, 'create'])->name('hipismo.hipodromos.create');
    Route::post('/hipodromos', [App\Http\Controllers\Hipismo\HipodromoController::class, 'store'])->name('hipismo.hipodromos.store');
    Route::get('/hipodromos/{id}/edit', [App\Http\Controllers\Hipismo\HipodromoController::class, 'edit'])->name('hipismo.hipodromos.edit');
    Route::post('/hipodromos/{id}', [App\Http\Controllers\Hipismo\HipodromoController::class, 'update'])->name('hipismo.hipodromos.update');
    Route::delete('/hipodromos/{id}', [App\Http\Controllers\Hipismo\HipodromoController::class, 'disable'])->name('hipismo.hipodromos.disable');

    Route::resource('/races', RaceController::class, [
        'names' => [
            'index' => 'hipismo.races.index',
            'create' => 'hipismo.races.create',
            'store' => 'hipismo.races.store',
            'show' => 'hipismo.races.show',
            'edit' => 'hipismo.races.edit',
            'update' => 'hipismo.races.update',
            'destroy' => 'hipismo.races.destroy',
        ]
    ]);

    Route::get('/races/{id}/setting', [App\Http\Controllers\Hipismo\RaceController::class, 'setting'])->name('hipismo.hipodromos.setting');
    Route::delete('/fixture/{id}', [App\Http\Controllers\Hipismo\FixtureRaceController::class, 'delete'])->name('hipismo.fixtures.delete');
    Route::post('/fixture/save', [App\Http\Controllers\Hipismo\FixtureRaceController::class, 'save'])->name('hipismo.fixtures.save');

    Route::post('/fixture_race_horses/combinacion-save/{race_id}', [App\Http\Controllers\Hipismo\FixtureRaceHorseController::class, 'combinacionsave'])->name('hipismo.horses.save');
    Route::get('/fixture_race_horses/{race_id}', [App\Http\Controllers\Hipismo\FixtureRaceHorseController::class, 'show'])->name('hipismo.horses.show');
    Route::post('/fixture_race_horses/save', [App\Http\Controllers\Hipismo\FixtureRaceHorseController::class, 'save'])->name('hipismo.horses.save');
    Route::post('/fixture_race_horses/{horse_id}/disable', [App\Http\Controllers\Hipismo\FixtureRaceHorseController::class, 'disable'])->name('hipismo.horses.disable');
    Route::post('/fixture_race_horses/{horse_id}/remate_winner', [App\Http\Controllers\Hipismo\FixtureRaceHorseController::class, 'remateWinner'])->name('hipismo.horses.rematewinner');
    Route::delete('/fixture_race_horses/{horse_id}/remove', [App\Http\Controllers\Hipismo\FixtureRaceHorseController::class, 'delete'])->name('hipismo.horses.delete');
    Route::get('/fixture_race_horses/get/{race_id}', [App\Http\Controllers\Hipismo\FixtureRaceHorseController::class, 'get'])->name('hipismo.horses.get');

    Route::get('/taquilla', [App\Http\Controllers\Hipismo\TaquillaController::class, 'create'])->name('hipismo.taquilla.create');
    Route::get('/taquilla-banca', [App\Http\Controllers\Hipismo\TaquillaController::class, 'banca'])->name('hipismo.taquilla.banca.create');
    Route::post('/taquilla-banca/save', [App\Http\Controllers\Hipismo\TaquillaController::class, 'bancasave'])->name('hipismo.taquilla.banca.save');
    Route::delete('/taquilla-banca/{banca_id}', [App\Http\Controllers\Hipismo\TaquillaController::class, 'bancadelete'])->name('hipismo.taquilla.banca.save');
    Route::get('/taquilla-banca/print/{banca_id}', [App\Http\Controllers\Hipismo\TaquillaController::class, 'print'])->name('hipismo.taquilla.banca.print');
    Route::get('/taquilla-banca/getcomming/races/{hipodromo_id}', [App\Http\Controllers\Hipismo\TaquillaController::class, 'getCommingRaces'])->name('hipismo.taquilla.banca.getcommingrace');
    Route::post('/taquilla/remate/save', [App\Http\Controllers\Hipismo\TaquillaController::class, 'rematesave'])->name('hipismo.taquilla.rematesave');
    Route::get('/taquilla/remate/getRemateCodes/{fixture_race_id}', [App\Http\Controllers\Hipismo\TaquillaController::class, 'getRemateCodes'])->name('hipismo.taquilla.getrematecodes');
    Route::get('/taquilla/remate/view/{code}', [App\Http\Controllers\Hipismo\TaquillaController::class, 'remateView'])->name('hipismo.taquilla.remateview');
    Route::get('/taquilla/remate/edit/{code}', [App\Http\Controllers\Hipismo\TaquillaController::class, 'remateEdit'])->name('hipismo.taquilla.remateedit');

    Route::get('/', [App\Http\Controllers\Hipismo\TaquillaController::class, 'dashboard'])->name('hipismo.taquilla.dashboard');
});
