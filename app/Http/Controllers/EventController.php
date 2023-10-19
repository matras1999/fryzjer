<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event; // Zakładając, że istnieje model Event

class EventController extends Controller
{
    public function calendar()
{
    $events = Event::all(); // Pobieranie dostępności terminów z bazy danych
    return view('wizyty', compact('events')); // Przekazanie danych do widoku "wizyty"
}
public function zapiszTermin(Request $request)
{
    // Pobierz dane z formularza
    $data = $request->input('data');
    $godzinaRozpoczecia = $request->input('godzina_rozpoczecia');
    $godzinaZakonczenia = $request->input('godzina_zakonczenia');

    // Zapisz dane do bazy danych (model Event)
    $event = new Event();
    $event->data = $data;
    $event->godzina_rozpoczecia = $godzinaRozpoczecia;
    $event->godzina_zakonczenia = $godzinaZakonczenia;
    // Ustaw pozostałe pola
    $event->save();

    // Przekieruj użytkownika z powiadomieniem o sukcesie lub błędzie
    return redirect()->back()->with('message', 'Termin został dodany.');
}


}
