<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->date('data');
            $table->time('godzina');
            $table->unsignedBigInteger('fryzjer_id');
            $table->unsignedBigInteger('usluga_id');
            // Dodaj inne kolumny, jeśli są potrzebne
            $table->timestamps();

            $table->foreign('fryzjer_id')->references('id')->on('fryzjerzy');
            $table->foreign('usluga_id')->references('id')->on('uslugi');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}

