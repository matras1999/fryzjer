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
    $user = auth()->user();
    $cartItems = $request->input('items');

    $total = 0;
    foreach ($cartItems as $item) {
        $total += (int) $item['quantity'] * (float) $item['price'];
    }

    // Teraz $total zawiera prawidłową całkowitą kwotę
    // Wyślij e-mail potwierdzający zamówienie
    Mail::to($user->email)->send(new OrderConfirmation($user, $cartItems, $total));

    session(['cartItems' => []]);

    // Dodatkowa logika
    // ...
    $message = 'E-mail z potwierdzeniem został wysłany.';

    return view('pomoc');
}


}
