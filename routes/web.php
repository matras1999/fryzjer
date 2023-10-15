<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UmowWizyteController;
use App\Http\Controllers\ProduktyController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ConfirmController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\ProfilController;

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
Route::get('/confirm', [ConfirmController::class, 'confirm'])->name('confirm');
Route::post('/confirm', [ConfirmController::class, 'confirm'])->name('confirm');
Route::match(['get', 'post'], '/send-sms', [SmsController::class, 'sendSms'])->name('send-sms');
Route::get('/profil', [ProfilController::class, 'profil'])->name('profil');
Route::post('/upload-avatar', [ProfilController::class, 'uploadAvatar'])->name('upload-avatar');
Route::put('/update-profile', [ProfilController::class, 'updateProfile'])->name('update-profile');

