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
    return view('welcome');
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


Route::post('/ticket-register', [App\Http\Controllers\RegisterController::class, 'create']);
Route::get('/print/{code}', [App\Http\Controllers\RegisterController::class, 'print']);
Route::get('/report-caja/{id}', [App\Http\Controllers\CajaController::class, 'report']);
