<?php

namespace App\Http\Controllers;

use Twilio\Rest\Client;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    public function sendSms(Request $request)
    {   //dd(env('TWILIO_SID'), env('TWILIO_TOKEN'));

        $sid = 'AC58658da51e044b0e324ebcfaf7d75ca4';
        $token = '4be88760b1cc4677195ee5475192f035';
        $twilio_number = '+12296000161';

       
     try {
            // Tworzenie klienta Twilio
            $client = new Client($sid, $token);

            // Wysyłanie wiadomości
            $message = $client->messages->create(
                $request->input('phone'), // Numer telefonu odbiorcy
                [
                    'from' => $twilio_number, // Twój numer Twilio
                    'body' => $request->input('body') // Treść wiadomości SMS
                ]
            );

            // Zwróć identyfikator wiadomości jako potwierdzenie wysłania
            return $message->sid;
        } catch (\Exception $e) {
            // Logowanie błędów i odpowiednia obsługa
            \Log::error("Error sending SMS: " . $e->getMessage());
            return response()->json(['error' => 'SMS could not be sent.'], 500);
        }
    }
}
