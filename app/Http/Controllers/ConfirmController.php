<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class ConfirmController extends Controller
{
    public function confirm()
    {
        // Pobierz imię zalogowanego klienta
        $imie_klienta = Auth::user()->name; 

        // Pobierz rezerwacje dla konkretnego klienta na podstawie imienia
        $reservations = Reservation::where('imie_klienta', $imie_klienta)
            ->orderBy('data')
            ->get();

        return view('confirm', ['reservations' => $reservations]);
    }
}


