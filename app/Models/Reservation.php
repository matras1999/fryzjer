<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{

   
    protected $table = 'reservations'; // Nazwa tabeli w bazie danych, jeśli jest inna niż domyślna


    public function user()
{
    return $this->belongsTo(User::class);
}

public function fryzjer()
{
    return $this->belongsTo('App\Models\Fryzjer', 'fryzjer_id');
}


    public function usluga()
{
    // Upewnij się, że używasz właściwej przestrzeni nazw dla Usluga
    return $this->belongsTo('App\Models\Usluga', 'usluga_id');
}
}
