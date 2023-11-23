<?php

namespace App\Http\Controllers;


use App\Models\Dostepnosc;
use App\Models\Reservation;
use App\Models\Fryzjer;
use App\Models\Usluga;
use Illuminate\Http\Request;

class ZatwierdzController extends Controller
{
   // ZatwierdzController.php

public function showConfirmations()
{

    $reservations = Reservation::with('fryzjer')->get();

    return view('zatwierdz', compact('reservations'));
}
public function processConfirmations()
{

    $reservations = Reservation::with('fryzjer')->get();

    return view('zatwierdz', compact('reservations'));
}
}
