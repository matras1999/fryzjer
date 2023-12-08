<?php

namespace App\Http\Controllers;

use Twilio\Rest\Client;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    public function sendSms(Request $request)
    {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_TOKEN');
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
