<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{

    use HasFactory;
    protected $fillable = [
 'data', 'godzina', 'imie_klienta', 'imie_fryzjera',
 ];

 public function getReservationDateAttribute() {
     return $this->data." ".$this->godzina;
 }

}
