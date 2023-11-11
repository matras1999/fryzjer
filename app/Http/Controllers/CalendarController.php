<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Dostepnosc;
use App\Models\Reservation;
use App\Models\Fryzjer;
use App\Models\Usluga;

class CalendarController extends Controller
{

    public $wybierzDate;
    private $uslugaId;

   

   public function getTimeOptions(Request $request,$usluga,$pracownik)
    {
        $wybierzDate = $request->wybierzDate;

        
        $selectedEmployeeId = $request->selectedEmployeeId;
       
        $uslugaGet = Usluga::find($pracownik);

        $startTime = Carbon::parse('08:00'); // Początkowy zakres czasowy
        $endTime = Carbon::parse('16:00'); // Końcowy zakres czasowy

        //TODO
        //if($pracownik = "dowolny"){
            // pobrac wszystkich pracownikow ktorzy sa przypisani do $usluga
       // }


        $serviceDuration = $selectedEmployeeId == 0 ? 0 : $uslugaGet->czas_trwania;
        $timeOptions = [];

        $dostepnosci = Dostepnosc::all();
        
            //dd($dostepnosci);

        foreach ($dostepnosci as $dostepnosc) {
            $dostepnoscStart = Carbon::parse($dostepnosc->start_time);
            $dostepnoscEnd = Carbon::parse($dostepnosc->end_time);

            for ($hour = $dostepnoscStart->hour; $hour <= $dostepnoscEnd->hour; $hour++) {
                for ($minute = ceil($dostepnoscStart->minute / 30) * 30; $minute < 60; $minute += 30) {
                    $czas = $dostepnoscStart->copy()->setHour($hour)->setMinute($minute);
                    if ($czas->copy()->addMinutes($serviceDuration) > $dostepnoscEnd) {
                        break;
                    } else {
                        $znaleziono = false;
                        foreach ($timeOptions as $czasWliscie) {
                            if ($czasWliscie->equalTo($czas)) {
                                $znaleziono = true;
                                break;
                            }
                        }
                        if (!$znaleziono) {
                        array_push($timeOptions, Carbon::parse($czas));
                        }
                    }
                }
            }
        }





        return view('calendar', compact('timeOptions'));
    }

    public function rezerwacja(Request $request)
    {
        // Tutaj możesz obsłużyć rezerwację wizyty, zapisując dane do bazy danych
        // Wykorzystaj $request, aby uzyskać wybrane godziny i pracownika oraz inne dane

        // Przykładowy kod obsługi rezerwacji:
        $reservation = new Reservation();
        $reservation->data = $request->data; // Przyjmij, że dane są przesyłane w formularzu
        $reservation->godzina = $request->time; // Wybrane godzina
        $reservation->fryzjer_id = $request->employee; // Wybrany pracownik (fryzjer)
        $reservation->save();

        // Możesz także dodać kod do obsługi powiadomienia lub innych działań

        return redirect()->back()->with('success', 'Wizyta została zarezerwowana.');
    }
}
