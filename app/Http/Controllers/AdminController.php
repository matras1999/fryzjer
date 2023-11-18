<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;

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
}
