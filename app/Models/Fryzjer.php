<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fryzjer extends Model
{
    protected $table = 'fryzjerzy';
     protected $fillable = ['imie', 'nazwisko', 'dostepnosc'];// Ustaw nazwę tabeli na "fryzjerzy"
    // Pozostałe właściwości modelu
}

