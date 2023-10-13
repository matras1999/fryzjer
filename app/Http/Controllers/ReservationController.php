<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Dodaj import Auth
use App\Models\Reservation;

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

        // Pobierz zalogowanego użytkownika
        $user = Auth::user();

        // Zapisz rezerwację
        $reservation = new Reservation();
        $reservation->data = $request->input('data');
        $reservation->godzina = $request->input('godzina');
        $reservation->rodzaj = $request->input('rodzaj');
        $reservation->cena = $request->input('cena');
        $reservation->imie_klienta = $user->name;
        

        // Ustaw inne pola rezerwacji, jeśli są potrzebne
        $reservation->save();

        // Przekieruj użytkownika lub wyświetl komunikat sukcesu
        return redirect()->back()->with('success', 'Wizyta została umówiona pomyślnie.');
    }
}
