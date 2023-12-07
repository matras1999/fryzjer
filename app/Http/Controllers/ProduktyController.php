<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produkt; // Upewnij się, że zaimportowałeś model Produkt

class ProduktyController extends Controller
{
    public function produkty()
    {
        // Pobieranie produktów z bazy danych
         
        $produkty = Produkt::paginate(8); // 10 produktów na stronę

        // Przekazywanie produktów do widoku
        return view('produkty', ['produkty' => $produkty]);
    }

    public function przejdzDoPodsumowania(Request $request)
    {

        $cartItems = $request->input('cartItems', []);
        
        // Tutaj możesz wykonać inne operacje związane z podsumowaniem, np. obliczyć całkowitą cenę itp.

        // Przekieruj użytkownika do widoku "koszyk.blade.php" z przekazanymi danymi
        return view('koszyk', compact('cartItems'));

    }

}
