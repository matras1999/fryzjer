<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ConfirmController extends Controller
{
    public function confirm()
{
    // Pobierz numer telefonu zalogowanego klienta
    $phone = Auth::user()->phone;

    // Pobierz rezerwacje dla konkretnego klienta na podstawie imienia
    $reservations = Reservation::where('user_id', Auth::id())
        ->orderBy('data')
        ->get();

    // Pobierz dane użytkowników
    $users = User::all(); // Załóżmy, że masz model User

    return view('confirm', ['reservations' => $reservations, 'phone' => $phone]);
}

}
