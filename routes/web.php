<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UmowWizyteController;
use App\Http\Controllers\ProduktyController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ConfirmController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\CalendarController;

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
Route::get('/produkty', [ProduktyController::class, 'produkty'])->name('produkty');
Route::get('/welcome', [App\Http\Controllers\HomeController::class, 'index'])->name('welcome');
Route::get('/confirm', [ConfirmController::class, 'confirm'])->name('confirm');
Route::post('/confirm', [ConfirmController::class, 'confirm'])->name('confirm');
Route::match(['get', 'post'], '/send-sms', [SmsController::class, 'sendSms'])->name('send-sms');
Route::get('/profil', [ProfilController::class, 'profil'])->name('profil');
Route::post('/upload-avatar', [ProfilController::class, 'uploadAvatar'])->name('upload-avatar');
Route::put('/update-profile', [ProfilController::class, 'updateProfile'])->name('update-profile');
Route::get('/umow_wizyte', [umowWizyteController::class, 'wyswietlUslugi'])->name('umow_wizyte');
Route::post('/umow_wizyte', [UmowWizyteController::class, 'wybierzUsluge'])->name('umow_wizyte');
Route::get('/calendar/{usluga}/{pracownik}', [CalendarController::class, 'getTimeOptions'])->name('calendar');
Route::post('/umow_wizyte', [UmowWizyteController::class, 'wybierzUsluge'])->name('umow_wizyte');
Route::post('/umow_wizyte', [UmowWizyteController::class, 'wybierzUsluge'])->name('umow_wizyte');
Route::get('/time-options/{wybierzDate}', [CalendarController::class, 'timeOptions']);
Route::post('/zatwierdz', [CalendarController::class, 'zatwierdz'])->name('zatwierdz');
Route::middleware(['can:isAdmin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/reservations', [AdminController::class, 'getReservations'])->name('admin.reservations');
    // Dodaj więcej tras admina według potrzeb
});


