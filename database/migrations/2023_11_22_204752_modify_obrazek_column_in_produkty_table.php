<?php
use Illuminate\Database\Migrations\Migration;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyObrazekColumnInProduktyTable extends Migration
{
    public function up()
    {
        Schema::table('produkty', function (Blueprint $table) {
            $table->dropColumn('obrazek'); // Usuń starą kolumnę
            $table->binary('obrazek_blob')->nullable(); // Dodaj nową kolumnę BLOB
        });
    }

    public function down()
    {
        Schema::table('produkty', function (Blueprint $table) {
            $table->dropColumn('obrazek_blob'); // Usuń kolumnę BLOB
            $table->string('obrazek')->nullable(); // Przywróć starą kolumnę
        });
    }
}
