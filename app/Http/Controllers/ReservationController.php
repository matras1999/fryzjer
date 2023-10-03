<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation; // Dodaj import modelu Reservation

class ReservationController extends Controller
{
    public function store(Request $request)
{
    // Walidacja danych z formularza
    $request->validate([
        'data' => 'required|date',
        'godzina' => 'required|date_format:H:i', // Sprawdzamy, czy godzina ma format HH:mm
        // Dodaj inne reguły walidacji
    ]);

    // Zapisz rezerwację
    $reservation = new Reservation();
    $reservation->data = $request->input('data');
    $reservation->godzina = $request->input('godzina');
    $reservation->imie_klienta = "";
    $reservation->imie_fryzjera= "";


    // Ustaw inne pola rezerwacji, jeśli są potrzebne
    $reservation->save();

    // Przekieruj użytkownika lub wyświetl komunikat sukcesu
    return redirect()->back()->with('success', 'Wizyta została umówiona pomyślnie.');
}

}
