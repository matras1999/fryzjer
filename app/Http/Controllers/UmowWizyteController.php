<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usluga;
use App\Models\Fryzjer;

class UmowWizyteController extends Controller
{
  public function wyswietlUslugi()
{
    $uslugi = Usluga::with('fryzjerzy')->get();

    return view('umow_wizyte', compact('uslugi'));
}

   public function wybierzUsluge(Request $request, Usluga $usluga)
{
    // Pobierz wybranego pracownika z żądania, jeśli nie ma wyboru to null
    $pracownikId = $request->input("pracownik_{$usluga->id}");
    
    // Sprawdź, czy wybrano "Dowolny pracownik"
    if ($pracownikId === '0') {
        // Tutaj możesz dodać logikę do wyboru dostępnego pracownika
        // Na przykład, możesz pobrać pierwszego dostępnego pracownika z listy dostępnych pracowników dla danej usługi i czasu
        $dostepniPracownicy = $usluga->fryzjerzy()->where('dostepnosc', true)->get();
        
        if ($dostepniPracownicy->isEmpty()) {
            // Obsłuż sytuację, gdy nie ma dostępnego pracownika
            // ...
        } else {
            // Wybierz pierwszego dostępnego pracownika
            $wybranyPracownik = $dostepniPracownicy->first();
            $pracownikId = $wybranyPracownik->id;
        }
    }

    // Obsłuż normalny przepływ, gdy pracownik jest wybrany
    // ...

    return redirect()->action([CalendarController::class, 'index'], ['usluga' => $usluga->id, 'pracownik' => $pracownikId]);
}


}
