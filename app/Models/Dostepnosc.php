<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dostepnosc extends Model
{
    protected $table = 'dostepnosc'; // Nazwa tabeli w bazie danych, jeśli jest inna niż domyślna

    protected $fillable = ['hairdresser_id', 'date', 'start_time', 'end_time']; // Pola, które można uzupełnić masowo

    // Dodatkowe metody lub relacje można dodać tutaj
}
