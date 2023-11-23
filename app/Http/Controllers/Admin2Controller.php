<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Fryzjer;
use App\Models\Dostepnosc;


class Admin2Controller extends Controller
{
    public function dashboard()
{
    return view('layouts.admin2.panel_admina2'); // Użyj ścieżki z kropkami
}

    public function getReservations()
{
    $reservations = Reservation::with('usluga') // Eager load the 'usluga' relationship
                        ->where('fryzjer_id', 2)
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

public function pokazGrafik()
{
    $grafik = Dostepnosc::where('hairdresser_id',2)
                ->paginate(10);
    return view('layouts.admin2.moj_grafik', compact('grafik'));
}

}
