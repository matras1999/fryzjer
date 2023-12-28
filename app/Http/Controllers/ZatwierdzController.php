<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class ZatwierdzController extends Controller
{
    public function showConfirmations()
    {
        // Tylko rezerwacje dla zalogowanego użytkownika
        $reservations = Reservation::with('fryzjer')
            ->where('user_id', Auth::id())
            ->get();

        return view('zatwierdz', compact('reservations'));
    }

    public function processConfirmations()
    {
        // Tylko rezerwacje dla zalogowanego użytkownika
        $reservations = Reservation::with('fryzjer')
            ->where('user_id', Auth::id())
            ->get();

        return view('zatwierdz', compact('reservations'));
    }
   public function cancel(Reservation $reservation)
{
    // Sprawdź, czy zalogowany użytkownik ma uprawnienia do anulowania tej rezerwacji
    if ($reservation->user_id !== auth()->id()) {
        // Wyświetl komunikat o błędzie lub przenieś na stronę 403
        abort(403, 'Brak uprawnienia do anulowania tej rezerwacji.');
    }

    // Usuń rezerwację
    $reservation->delete();

    // Ponownie pobierz rezerwacje dla zalogowanego użytkownika
    $reservations = Reservation::where('user_id', auth()->id())->get();

    // Przekieruj użytkownika z komunikatem sukcesu
    return view('zatwierdz', compact('reservations'))->with('success', 'Rezerwacja została anulowana.');
}
}
