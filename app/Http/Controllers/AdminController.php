<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Produkt;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Fryzjer;
use App\Models\Dostepnosc;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

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
    $produkty = Produkt::all(); // Pobiera wszystkie produkty z bazy danych
    return view('layouts.admin.tymczasowy', compact('produkty'));
}
public function showProducts()
{
    $produkty = Produkt::all(); // Pobiera wszystkie produkty z bazy danych
    return view('layouts.admin.tymczasowy', compact('produkty'));
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
public function updateProduct(Request $request, $id)
    {
        $produkt = Produkt::findOrFail($id);
        // Walidacja danych wejściowych
        $validator = Validator::make($request->all(), [
            'nazwa' => 'required|string|max:255',
            'opis' => 'required|string',
            'cena' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Znajdź produkt i zaktualizuj jego dane
        $produkt = Produkt::findOrFail($id);
        $produkt->nazwa = $request->input('nazwa');
        $produkt->opis = $request->input('opis');
        $produkt->cena = $request->input('cena');
        //dd($request->all());
        $produkt->save();

        // Przekieruj z powrotem z wiadomością o sukcesie
        return redirect()->back()->with('success', 'Produkt zaktualizowany.');
    }



public function delete($produktId)
{
    $produkt = Produkt::findOrFail($produktId);
    $produkt->delete();

    // Dodaj tutaj logikę obsługi usunięcia obrazka z dysku, jeśli to konieczne

    return redirect()->back()->with('success', 'Produkt został usunięty.');
}
public function showSchedule()
{
    $grafik = Dostepnosc::where('hairdresser_id', 1)->get();

    return view('layouts.admin.graf', compact('grafik'));
}

public function showClients()
{
    $users = User::where('role', 'user')->get(); // Pobierz użytkowników z rolą 'user'

    return view('layouts.admin.lista', compact('users')); // Przekaż zmienne do widoku
}

  public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Dodaj tutaj logikę usunięcia powiązanych danych, np. avataru użytkownika
        // Storage::delete('avatars/' . $user->avatar);

        $user->delete();

        return redirect()->back()->with('success', 'Użytkownik został usunięty.');
    }

    // ...
}
