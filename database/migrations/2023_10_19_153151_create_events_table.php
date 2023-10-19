<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id(); // ID wydarzenia
            $table->unsignedBigInteger('fryzjer_id'); // ID fryzjera, do którego przypisane jest wydarzenie
            $table->dateTime('start'); // Czas rozpoczęcia wydarzenia
            $table->dateTime('end'); // Czas zakończenia wydarzenia
            $table->string('title'); // Tytuł wydarzenia (np. "Dostępny" lub "Zajęty")
            $table->timestamps(); // Czas tworzenia i aktualizacji rekordu

            // Definicja klucza obcego do powiązania z tabelą fryzjerzy (przykład)
            $table->foreign('fryzjer_id')
                ->references('id')
                ->on('fryzjerzy')
                ->onDelete('cascade'); // Zachowaj spójność bazy danych
        });
    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
}
