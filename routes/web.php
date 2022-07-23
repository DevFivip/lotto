<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\CajaController;
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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::resource('/usuarios', UserController::class);
Route::resource('/cajas', CajaController::class);
Route::resource('/tickets', TicketController::class);
Route::resource('/animals', AnimalController::class);
Route::resource('/customers', CustomerController::class);
Route::resource('/payments', PaymentController::class);
Route::resource('/schedules', ScheduleController::class);
Route::resource('/resultados', ResultController::class);


Route::post('/tickets/makepay/{id}', [App\Http\Controllers\RegisterController::class, 'payAnimalito']);
Route::get('/tickets/pay/{code}', [App\Http\Controllers\TicketController::class, 'pay']);
Route::post('/ticket-register', [App\Http\Controllers\RegisterController::class, 'create']);
Route::post('/ticket-validate/{code}', [App\Http\Controllers\TicketController::class, 'validateToPay']);
Route::get('/print/{code}', [App\Http\Controllers\RegisterController::class, 'print']);
Route::get('/report-caja/{id}', [App\Http\Controllers\CajaController::class, 'report']);
Route::get('/reports', [App\Http\Controllers\ReportControllers::class, 'index']);
Route::get('/reports/general', [App\Http\Controllers\ReportControllers::class, 'general']);

Route::delete('/register/{code}', [App\Http\Controllers\RegisterController::class, 'destroy']);
