<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UmowWizyteController;
use App\Http\Controllers\ProduktyController;
use App\Http\Controllers\ReservationController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();




Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//routes/web.php
Route::get('/umow_wizyte', [UmowWizyteController::class, 'umowWizyte'])->name('umow_wizyte');
Route::get('/produkty', [ProduktyController::class, 'produkty'])->name('produkty');
Route::get('/welcome', [App\Http\Controllers\HomeController::class, 'index'])->name('welcome');
Route::post('/umow_wizyte', [ReservationController::class, 'store']);


