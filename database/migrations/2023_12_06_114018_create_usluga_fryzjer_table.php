<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUslugaFryzjerTable extends Migration
{
    public function up()
    {
        Schema::create('usluga_fryzjer', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usluga_id');
            $table->unsignedBigInteger('fryzjer_id');
            $table->timestamps();

            $table->foreign('usluga_id')->references('id')->on('uslugi')->onDelete('cascade');
            $table->foreign('fryzjer_id')->references('id')->on('fryzjerzy')->onDelete('cascade');

            $table->unique(['usluga_id', 'fryzjer_id']); // Opcjonalnie, aby zapobiec duplikatom
        });
    }

    public function down()
    {
        Schema::dropIfExists('usluga_fryzjer');
    }
}
