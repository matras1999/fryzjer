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
        $twilio_number = env('TWILIO_FROM');

       
        $client = new Client($sid, $token);


        $message = $client->messages->create(
            '+48790235497', // Numer odbiorcy, na który chcesz wysłać SMS
            [
                'from' => $twilio_number,
                'body' => 'Witaj, to jest testowa wiadomość z Laravel!'
            ]
        );
        
        return $message->sid;
    }
}
