<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usluga extends Model
{
    use HasFactory;

    protected $table = 'uslugi';

      public function fryzjerzy()
    {
        return $this->belongsToMany(Fryzjer::class, 'usluga_fryzjer', 'usluga_id', 'fryzjer_id');
    }
}
