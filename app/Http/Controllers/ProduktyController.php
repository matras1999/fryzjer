<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProduktyController extends Controller
{
    public function produkty()
{
    return view ('produkty');
}
}
