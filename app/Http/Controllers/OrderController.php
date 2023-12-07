<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;

class OrderController extends Controller
{
    public function confirmOrder(Request $request)
    {
        // Pobierz zalogowanego użytkownika
        $user = auth()->user();

        // Pobierz dane o zamówieniu z formularza
        $cartItems = $request->input('items'); // Zakładam, że dane są przekazywane w formie tablicy

        // Wyślij e-mail potwierdzający zamówienie
        Mail::to($user->email)->send(new OrderConfirmation($user, $cartItems));
        session(['cartItems' => []]);
        // Dodatkowa logika, np. zapis zamówienia do bazy danych
        // ...
        $message = 'E-mail z potwierdzeniem został wysłany.';

        // Zwróć odpowiedź JSON
        return view('pomoc');
    }
}
