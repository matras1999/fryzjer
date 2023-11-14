<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Dostepnosc;
use App\Models\Reservation;
use App\Models\Fryzjer;
use App\Models\Usluga;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Response;


class CalendarController extends Controller
{

    public function getTimeOptions(Request $request, $usluga, $pracownik)
    {
        session(['usluga' => $usluga, 'pracownik' => $pracownik]);
        $timeOptions = [];

        return view('calendar', compact('timeOptions'));
    }

    public function timeOptions(Request $request, $wybierzDate)
    {

        $selectedEmployeeId = 1;

        $uslugaId = session('usluga');
        $pracownikId = session('pracownik');

        $usluga = Usluga::find($uslugaId);

        $startTime = Carbon::parse('08:00'); // Początkowy zakres czasowy
        $endTime = Carbon::parse('16:00'); // Końcowy zakres czasowy

        //TODO
        //if($pracownik = "dowolny"){
        // pobrac wszystkich pracownikow ktorzy sa przypisani do $usluga
        // }

        $serviceDuration = $selectedEmployeeId == 0 ? 0 : $usluga->czas_trwania;
        $timeOptions = [];
        
        $dostepnosci = Dostepnosc::where('hairdresser_id', $pracownikId)
        ->where('date', $wybierzDate)
        ->get();

        foreach ($dostepnosci as $dostepnosc) {
            $dostepnoscStart = Carbon::parse($dostepnosc->start_time);
            $dostepnoscEnd = Carbon::parse($dostepnosc->end_time);
        
            $period = CarbonPeriod::create($dostepnoscStart, '30 minutes', $dostepnoscEnd);
        
            foreach ($period as $czas) {
                $czas->setDate(2000, 1, 1); // Ustawienie arbitralnej daty (w tym przypadku 2000-01-01)
                
                if ($czas->copy()->addMinutes($serviceDuration) > $dostepnoscEnd) {
                    break;
                } else {
                    $formattedTime = $czas->format('H:i'); // Formatowanie tylko godzin i minut
                    if (!in_array($formattedTime, $timeOptions)) {
                        $timeOptions[] = $formattedTime;
                    }
                }
            }
        }

        return Response::json(['timeOptions' => $timeOptions]);
    }

    public function rezerwacja(Request $request)
    {

        $reservation = new Reservation();
        $reservation->data = $request->data; // Przyjmij, że dane są przesyłane w formularzu
        $reservation->godzina = $request->time; // Wybrane godzina
        $reservation->fryzjer_id = $request->employee; // Wybrany pracownik (fryzjer)
        $reservation->save();


        return redirect()->back()->with('success', 'Wizyta została zarezerwowana.');
    }
}
