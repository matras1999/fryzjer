<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
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
    $uslugaId = session('usluga');
    $pracownikId = session('pracownik');
    session(['wybierzDate' => $wybierzDate]);

    $usluga = Usluga::find($uslugaId);
    $serviceDuration = $usluga->czas_trwania;

    if ($pracownikId != 0) {
        $dostepnosci = Dostepnosc::where('hairdresser_id', $pracownikId)
                                 ->where('date', $wybierzDate)
                                 ->get();
    } else {
        $fryzjerIds = $usluga->fryzjerzy()->pluck('fryzjer_id');
        $dostepnosci = Dostepnosc::where('date', $wybierzDate)
                                 ->whereIn('hairdresser_id', $fryzjerIds)
                                 ->get();
    }

    $timeOptions = [];

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
                        array_push($timeOptions, $czas);
                    }
                }
            }
        }
    }

    $timeArray = [];
    foreach ($timeOptions as $date) {
        $carbonDate = new Carbon($date);
        $timeArray[] = $carbonDate->format('H:i');
    }

    return Response::json(['timeOptions' => $timeArray]);
}

    public function zatwierdz(Request $request) {
    $selectedTime = $request->input('selectedTime'); // Pobieranie danych z requestu
    $uslugaId = session('usluga');
    $pracownikId = session('pracownik');
    $wybierzDate = session('wybierzDate');

    $usluga = Usluga::find($uslugaId);

    // Konwersja stringa na instancję Carbon
$selectedTimeCarbon = Carbon::parse($selectedTime);

    $startTime = $selectedTime;
    $endTime = $selectedTimeCarbon->copy()->addMinutes($usluga->czas_trwania);



   
    // druga tabela logika najwazniejsze
    if($pracownikId != 0){
    $dostepnosc = Dostepnosc::where('hairdresser_id', $pracownikId)
    ->where('date', $wybierzDate)
    ->where('start_time', '<=', $startTime)
    ->where('end_time', '>=', $endTime)
    ->first();
    }else{
     $dostepnosc = Dostepnosc::where('date', $wybierzDate)
        ->where('start_time', '<=', $startTime)
        ->where('end_time', '>=', $endTime)
        ->whereIn('hairdresser_id', function ($query) use ($usluga) {
            $query->select('fryzjer_id')
                ->from('usluga_fryzjer')
                ->where('usluga_id', $usluga->id);
        })
        ->first();
    }

        $reservation = new Reservation();
$reservation->data = $wybierzDate; // Przyjmij, że dane są przesyłane w formularzu
$reservation->godzina_od = $selectedTime; // Wybrane godzina
$reservation->godzina_do = $endTime->format('H:i'); // Zakładając, że $endTime to obiekt Carbon
$reservation->fryzjer_id = $dostepnosc->hairdresser_id; // Wybrany pracownik (fryzjer)
$reservation->usluga_id = $uslugaId;
$reservation->created_at = now();

// Tutaj przypisujemy zalogowanego użytkownika do rezerwacji
$user = Auth::user(); // Pobierz zalogowanego użytkownika
if ($user) {
    $reservation->user_id = $user->id; // Przypisz ID zalogowanego użytkownika
}

$reservation->save();



    $noweDostepnosci = [];
            $dostepnosc1 = new Dostepnosc; // lub klonuj $dostepnosc, jeśli to konieczne
                    $dostepnosc2 = new Dostepnosc; // lub klonuj $dostepnosc, jeśli to konieczne


    function splitDostepnosc($dostepnosc, $reservedStartTime, $reservedEndTime, $wybierzDate,$noweDostepnosci,$dostepnosc1,$dostepnosc2) {
    
    // Sprawdź pierwszy przedział czasowy
    $dostepnosc1StartTime = Carbon::parse($dostepnosc->start_time);
    $dostepnosc1EndTime = Carbon::parse($reservedStartTime);
    if ($dostepnosc1EndTime->diffInMinutes($dostepnosc1StartTime) >= 30) {
        $dostepnosc1->start_time = $dostepnosc1StartTime->format('H:i');
        $dostepnosc1->end_time = $dostepnosc1EndTime->format('H:i');
        $dostepnosc1->date = $wybierzDate;
        $dostepnosc1->hairdresser_id = $dostepnosc->hairdresser_id;
        $dostepnosc1->save();
    }

    // Sprawdź drugi przedział czasowy
    $dostepnosc2StartTime = Carbon::parse($reservedEndTime);
    $dostepnosc2EndTime = Carbon::parse($dostepnosc->end_time);
    if ($dostepnosc2EndTime->diffInMinutes($dostepnosc2StartTime) >= 30) {
        $dostepnosc2->start_time = $dostepnosc2StartTime->format('H:i');
        $dostepnosc2->end_time = $dostepnosc2EndTime->format('H:i');
        $dostepnosc2->date = $wybierzDate;
        $dostepnosc2->hairdresser_id = $dostepnosc->hairdresser_id;
                $dostepnosc2->save();
    }

}

  splitDostepnosc($dostepnosc, $startTime, $endTime, $wybierzDate, $noweDostepnosci,$dostepnosc1,$dostepnosc2);
  $dostepnosc->delete();



    return redirect()->action([ZatwierdzController::class, 'showConfirmations']);

    }

}
