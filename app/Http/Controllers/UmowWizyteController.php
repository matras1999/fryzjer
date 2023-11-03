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
        // Pobierz wybranego pracownika z żądania
        $pracownikId = $request->input("pracownik_{$usluga->id}");

        // Tutaj możesz dodać kod obsługi wyboru usługi i pracownika,
        // na przykład zapis do sesji lub bazy danych.

        return redirect()->action([CalendarController::class, 'index'], ['usluga' => $usluga, 'pracownik' => $pracownikId]);
    }
}
