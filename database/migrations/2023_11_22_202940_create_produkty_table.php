<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduktyTable extends Migration
{
    public function up()
    {
        Schema::create('produkty', function (Blueprint $table) {
            $table->id();
            $table->string('nazwa');
            $table->text('opis');
            $table->decimal('cena', 8, 2);
            $table->string('obrazek')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('produkty');
    }
}

