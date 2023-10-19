<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{

    use HasFactory;
    protected $fillable = [
 'data', 'godzina', 'rodzaj', 'cena', 'imie_klienta','availability',
 ];

 public function getReservationDateAttribute() {
     return $this->data." ".$this->godzina;
 }





}
