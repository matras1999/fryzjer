<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
class KoszykController extends Controller
{


public function hej()
    {
        //dd('Akcja przejdzDoPodsumowania jest wywoływana.');

      

        // Tutaj możesz wykonać inne operacje związane z podsumowaniem, np. obliczyć całkowitą cenę itp.

        // Przekieruj użytkownika do widoku "koszyk.blade.php" z przekazanymi danymi
        return view('koszyk');
    }


public function przejdzDoPodsumowania(Request $request)
{
    
    // Pierwszy poziom 'cartItems'
    $cartItems = $request->input('cartItems.cartItems'); 

    if ($cartItems) {
        // $cartItems powinno być teraz tablicą produktów
        foreach ($cartItems as $item) {
            // Teraz możesz uzyskać dostęp do 'id', 'name', 'price' każdego produktu
            $id = $item['id'];
            $name = $item['name'];
            $price = $item['price'];
            
            // Przetwarzaj każdy element koszyka...
        }

        // Zapisz dane koszyka do sesji
        session(['cartItems' => $cartItems]);

        // Możesz teraz zwrócić odpowiedź lub zrobić przekierowanie
          $html = view('koszyk', compact('cartItems'))->render();

        // Zwracanie HTML jako część odpowiedzi JSON
        return response()->json(['html' => $html]);

    }

    // Obsługa błędów, jeśli $cartItems nie istnieje
    return response()->json(['error' => 'No cart items provided'], 400);
}
public function pokazKoszyk()
{
    // Odzyskaj dane koszyka z sesji
    $cartItems = session('cartItems', []);
    $totalPrice = array_sum(array_column($cartItems, 'price'));

    // Przekazanie danych do widoku
    return view('koszyk', ['cartItems' => $cartItems, 'totalPrice' => $totalPrice]);
}
 public function usunWszystkieProdukty(Request $request)
    {
        
        // Usuń wszystkie produkty z sesji
        Session::forget('cartItems');
        
        // Przekieruj użytkownika z powrotem do koszyka lub innej strony
        return redirect()->route('koszyk')->with('success', 'Wszystkie produkty zostały usunięte z koszyka.');
    }


}

