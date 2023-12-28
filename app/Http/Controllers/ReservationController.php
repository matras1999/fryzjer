<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'data' => 'required|date',
            'godzina' => 'required|date_format:H:i',
            // Dodaj inne reguły walidacji
        ]);

         $user = Auth::user();
        Log::debug('Zalogowany użytkownik ID: ' . $user->id);
        $reservation = new Reservation();
        $reservation->user_id = $user->id; // Przypisanie ID użytkownika do rezerwacji
        $reservation->data = $request->input('data');
        $reservation->godzina = $request->input('godzina');
        $reservation->rodzaj = $request->input('rodzaj');
        $reservation->cena = $request->input('cena');
        $reservation->imie_klienta = $user->name;

        // Określ dostępność
        $available = $this->sprawdzDostepnosc($reservation->data, $reservation->godzina);

        if ($available) {
            $reservation->availability = 'Wolne';
        } else {
            $reservation->availability = 'Brak miejsc';
        }

        $reservation->save();

        // Przekieruj użytkownika lub wyświetl komunikat sukcesu
        return redirect('confirm');
    }

    // Funkcja do sprawdzania dostępności
    private function sprawdzDostepnosc($data, $godzina)
    {
        // Tutaj dodaj logikę sprawdzania dostępności na podstawie daty i godziny
        // Jeśli jest dostępne, zwróć true, w przeciwnym razie false
        // Przykład: Sprawdzamy dostępność dla danej daty i godziny
        // return true; // Dostępne
        // return false; // Brak miejsc
    }
}
