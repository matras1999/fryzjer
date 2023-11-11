<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usluga;
use App\Models\Fryzjer;

class UmowWizyteController extends Controller
{
    public function wyswietlUslugi()
    {
        $uslugi = Usluga::all();
         $fryzjerzy = Fryzjer::all(['id', 'nazwisko', 'imie']); // Pobierz wszystkich fryzjerów

        return view('umow_wizyte', compact('uslugi', 'fryzjerzy'));
    }

   public function wybierzUsluge(Request $request, Usluga $usluga)
{
    // Pobierz wybranego pracownika z żądania, jeśli nie ma wyboru to null
    $pracownikId = $request->input("pracownik_{$usluga->id}") ?: null;

    // Obsłuż sytuację, gdy nie wybrano pracownika
    if ($pracownikId === null) {
        // Zapisz informacje o wyborze usługi bez wybranego pracownika
        // ...
        return redirect()->action([CalendarController::class, 'index'], ['usluga' => $usluga->id]);
    }

    // Obsłuż normalny przepływ, gdy pracownik jest wybrany
    // ...

    return redirect()->action([CalendarController::class, 'index'], ['usluga' => $usluga->id, 'pracownik' => $pracownikId]);
}

}
