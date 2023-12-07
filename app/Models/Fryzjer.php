<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fryzjer extends Model
{
protected $table = 'fryzjerzy'; // Poprawna nazwa tabeli
   public function uslugi()
    {
        return $this->belongsToMany(Usluga::class, 'usluga_fryzjer');
    }
}

