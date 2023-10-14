<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
class SmsController extends Controller
{
   public function sendSms()
{
    $sid = config('services.twilio.sid');
    $token = config('services.twilio.auth_token');
    $twilioPhoneNumber = config('services.twilio.phone_number');

    $client = new Client($sid, $token);

    $to = Auth::user()->phone; // Pobierz numer telefonu zalogowanego użytkownika
    $message = "Przypominamy o nadchodzącej wizycie!";

    $client->messages->create($to, ['from' => $twilioPhoneNumber, 'body' => $message]);

    return "Wiadomość SMS została wysłana.";
}
}
