<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Produkt;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Fryzjer;
use App\Models\Dostepnosc;
class AdminController extends Controller
{
    public function dashboard()
{
    return view('layouts.admin.panel_admina'); // Użyj ścieżki z kropkami
}

     public function getReservations()
{
    $reservations = Reservation::with('usluga') // Eager load the 'usluga' relationship
                        ->where('fryzjer_id', 1)
                        ->get(['id', 'data', 'godzina_od', 'godzina_do', 'usluga_id'])
                        ->map(function ($reservation) {
                            // Make sure you handle the case where 'usluga' might be null
                            $serviceName = optional($reservation->usluga)->nazwa ?? 'Brak usługi';
                            return [
                                'title' => $serviceName,
                                'start' => $reservation->data . 'T' . $reservation->godzina_od,
                                'end' => $reservation->data . 'T' . $reservation->godzina_do,
                            ];
                        });

    return response()->json($reservations);
}
public function grafiki()
{
     $fryzjerzy = Fryzjer::where('id', '>', 0)->get();

    return view('layouts.admin.ustaw_grafik',compact('fryzjerzy'));
}
public function zapiszGrafik(Request $request)
{
    //dd($request->all());

    // Walidacja danych z formularza
   $validatedData = $request->validate([
        'fryzjer_id' => 'required|integer',
        'daty' => 'required|array',
        'godzina_od' => 'required|date_format:H:i',
        'godzina_do' => 'required|date_format:H:i|after_or_equal:godzina_od'
    ]);

    $dates = [];
foreach ($validatedData['daty'] as $dataString) {
    $datesArray = explode(',', $dataString);
    foreach ($datesArray as $date) {
        $dates[] = $date; // Dodajemy datę na koniec tablicy $dates
    }
}
     foreach ($dates as $data) {
        Dostepnosc::create([
            'hairdresser_id' => $validatedData['fryzjer_id'],
            'date' => $data,
            'start_time' => $validatedData['godzina_od'],
            'end_time' => $validatedData['godzina_do'],
        ]);
}


    return redirect()->back()->with('success', 'Grafik zapisany pomyślnie.');
}
public function zarzadzajSklepem()
{
    return view('layouts.admin.tymczasowy');
}

public function dodajProdukt(Request $request)
{
    $request->validate([
        'nazwa' => 'required|string|max:255',
        'opis' => 'required|string',
        'cena' => 'required|numeric',
        'obrazek' => 'required|image|max:2048', // Maksymalny rozmiar 2MB
    ]);

    $path = $request->file('obrazek')->store('produkty', 'public'); // Zapisuje w storage/app/public/produkty

    $produkt = new Produkt();
    $produkt->nazwa = $request->input('nazwa');
    $produkt->opis = $request->input('opis');
    $produkt->cena = $request->input('cena');
    $produkt->obrazek = $path; // Zapisuje tylko ścieżkę do obrazu
    $produkt->save();

    return back()->with('success', 'Produkt został dodany.');
}

}
