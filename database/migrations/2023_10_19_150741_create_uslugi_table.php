<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUslugiTable extends Migration
{
    public function up()
    {
        Schema::create('uslugi', function (Blueprint $table) {
            $table->id();
            $table->string('nazwa');
            $table->integer('czas_trwania'); // Przechowuje czas trwania usługi w minutach
            $table->decimal('cena', 8, 2); // Przechowuje cenę w formacie 8 cyfr całkowitych i 2 miejsc po przecinku
            $table->unsignedBigInteger('fryzjer_id'); // Klucz obcy do powiązania usługi z fryzjerem
            $table->timestamps();

            // Dodanie klucza obcego
            $table->foreign('fryzjer_id')->references('id')->on('fryzjerzy')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('uslugi');
    }
}
