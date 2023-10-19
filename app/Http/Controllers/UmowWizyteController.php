<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fryzjer; // Zakładając, że istnieje model Fryzjer
use App\Models\Usluga; // Zakładając, że istnieje model Usluga
use App\Models\Reservation; // Zakładając, że istnieje model Reservation

class UmowWizyteController extends Controller
{
    public function showForm()
    {
        // Pobierz dostępnych fryzjerów
        $fryzjerzy = Fryzjer::all();

        // Pobierz dostępne usługi
    $uslugi = Usluga::all();
$reservations = Reservation::all()->map(function ($reservation) {
    $color = 'purple'; // Domyślny kolor

    if ($reservation->availability === 'Brak miejsc') {
        $color = 'red'; // Dla braku miejsc
    } elseif ($reservation->availability === 'Kilka miejsc') {
        $color = 'yellow'; // Dla kilku miejsc
    } elseif ($reservation->availability === 'Wolne') {
        $color = 'green'; // Dla wolnych miejsc
    }

    return [
        //'title' => 'Wizyta', // Tytuł wydarzenia
        'start' => $reservation->data . 'T' . $reservation->godzina, // Data i godzina rozpoczęcia
        'backgroundColor' => $color, // Kolor tła na podstawie dostępności
        // Dodaj inne pola, które chcesz wyświetlić w kalendarzu
    ];
});



        return view('umow_wizyte', compact('fryzjerzy', 'uslugi','reservations'));
    }

    public function zapiszWizyte(Request $request)
    {
        // Pobierz dane z formularza
        $data = $request->input('data');
        $godzina = $request->input('godzina');
        $fryzjerId = $request->input('fryzjer');
        $uslugaId = $request->input('usluga');

        // Zapisz rezerwację do bazy danych (model Reservation)
        $reservation = new Reservation();
        $reservation->data = $data;
        $reservation->godzina = $godzina;
        $reservation->fryzjer_id = $fryzjerId;
        $reservation->usluga_id = $uslugaId;
        // Dodaj inne pola, które mogą być wymagane
        $reservation->save();

        // Przekieruj użytkownika z powiadomieniem o sukcesie lub błędzie
        return redirect()->back()->with('message', 'Wizyta została umówiona.');
    }
}
