<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\CajaController;
use App\Http\Controllers\CajaRegisterController;
use App\Http\Controllers\CashAdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController2::class, 'index'])->name('home');
// Route::get('/home2', [App\Http\Controllers\HomeController2::class, 'index'])->name('home2');

Route::resource('/usuarios', UserController::class);
Route::resource('/cajas', CajaController::class);
Route::resource('/caja-registers', CajaRegisterController::class);
Route::resource('/tickets', TicketController::class);
Route::resource('/animals', AnimalController::class);
Route::resource('/customers', CustomerController::class);
Route::resource('/payments', PaymentController::class);
Route::resource('/schedules', ScheduleController::class);
Route::resource('/resultados', ResultController::class);
Route::resource('/cash-admins', CashAdminController::class);

Route::get('/chart', [App\Http\Controllers\JugadasController::class, 'plays']);
Route::get('/choose', [App\Http\Controllers\JugadasController::class, 'choose']);

Route::get('/tickets-repeat', [App\Http\Controllers\TicketController::class, 'repeat']);

Route::post('/tickets/makepay/{id}', [App\Http\Controllers\RegisterController::class, 'payAnimalito']);
Route::get('/tickets/pay/{code}', [App\Http\Controllers\TicketController::class, 'pay']);
Route::post('/ticket-register', [App\Http\Controllers\RegisterController::class, 'create']);
Route::post('/ticket-validate/{code}', [App\Http\Controllers\TicketController::class, 'validateToPay']);
Route::get('/print-direct/{code}', [App\Http\Controllers\RegisterController::class, 'print_direct']);
Route::get('/print/{code}', [App\Http\Controllers\RegisterController::class, 'print']);

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

// Route::get('/scrap', [App\Http\Controllers\ScrappingController::class, 'scrap']);
// Route::post('/send-results-complement', [App\Http\Controllers\ScrappingController::class, 'getResult']);
