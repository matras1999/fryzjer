<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dostepnosc extends Model
{
protected $fillable = ['hairdresser_id', 'date', 'start_time', 'end_time'];
public $timestamps = false;
    protected $table = 'dostepnosc'; // Nazwa tabeli w bazie danych, jeśli jest inna niż domyślna


    // Dodatkowe metody lub relacje można dodać tutaj
}
