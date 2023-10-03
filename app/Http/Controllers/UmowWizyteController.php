<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;

class UmowWizyteController extends Controller
{
    public function __construct(Reservation $reservationModel)
    {
        $this->reservationModel = $reservationModel;
        $this->middleware('auth'); // Dodaj middleware autoryzacji dla tego kontrolera
    }

    public function umowWizyte()
    {
        $list = $this->reservationModel->select(["data", "godzina"])->get();
        //dd($list->first()->reservation_date);
        $reservations = [];
        foreach($list as $row) {
            $date = new \DateTime($row->reservation_date);
            $date_end = clone $date;
            $date_end->add(new \DateInterval('PT1H'));
            $reservations[] = [
                'title' => 'rezerwowane',
                'start' => $date->format('c'),
                'end' => $date_end->format('c'),
            ];
        }
        // Tutaj możesz dodać logikę obsługi umawiania wizyty
        // Na przykład, przekierowanie do formularza umawiania wizyty

        return view('wizyty')->with(['reservations' => $reservations]);
    }
}
