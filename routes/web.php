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
use App\Http\Controllers\ZatwierdzController;
use App\Http\Controllers\Admin2Controller;
use App\Http\Controllers\Admin3Controller;
use App\Http\Controllers\KoszykController;

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
Route::get('/produkty/obrazek/{id}', [ProduktyController::class, 'showImage'])->name('produkty.showImage');
Route::post('/przejdz-do-podsumowania', [KoszykController::class, 'przejdzDoPodsumowania'])->name('/przejdz-do-podsumowania');
Route::get('/koszyk',[KoszykController::class, 'pokazKoszyk'])->name('koszyk');
//Route::post('/przejdz-do-podsumowania', [ProduktyController::class, 'przejdzDoPodsumowania'])->name('przejdz-do-podsumowania');

//admin1
Route::middleware(['can:isAdmin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/reservations', [AdminController::class, 'getReservations'])->name('admin.reservations');
    Route::get('/admin/zarzadzaj-grafikami', [AdminController::class, 'grafiki'])->name('admin.zarzadzaj-grafikami');
    Route::post('/admin/zapisz-grafik', [AdminController::class, 'zapiszGrafik'])->name('admin.zapisz-grafik');
    Route::get('/admin/zarzadzaj-sklepem', [AdminController::class, 'zarzadzajSklepem'])->name('admin.zarzadzaj-sklepem');
    Route::post('/admin/dodaj-produkt', [AdminController::class, 'dodajProdukt'])->name('admin.dodaj-produkt');


});
//admin2
Route::middleware(['can:isAdmin1'])->group(function () {
    Route::get('/admin1/dashboard', [Admin2Controller::class, 'dashboard'])->name('admin2.dashboard');
    Route::get('/admin1/reservations', [Admin2Controller::class, 'getReservations'])->name('admin2.reservations');
    Route::get('/admin1/pokaz-grafik', [Admin2Controller::class, 'pokazGrafik'])->name('admin2.pokaz-grafik');
});
//admin3
Route::middleware(['can:isAdmin2'])->group(function () {
    Route::get('/admin2/dashboard', [Admin3Controller::class, 'dashboard'])->name('admin3.dashboard');
    Route::get('/admin2/reservations', [Admin3Controller::class, 'getReservations'])->name('admin3.reservations');
    Route::get('/admin2/pokaz-grafik', [Admin3Controller::class, 'pokazGrafik'])->name('admin3.pokaz-grafik');
});


Route::get('/show-confirmations', [ZatwierdzController::class, 'showConfirmations'])->name('show-confirmations');
Route::get('/zatwierdz', [ZatwierdzController::class, 'processConfirmations'])->name('zatwierdz');

