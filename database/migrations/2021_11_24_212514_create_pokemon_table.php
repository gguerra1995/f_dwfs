<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePokemonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pokemon', function (Blueprint $table) {
            $table->id();
            $table->longText("photo");
            $table->string("name");
            $table->integer("ps");
            $table->integer("atq");
            $table->integer("df");
            $table->integer("atq_spl");
            $table->integer("df_spl");
            $table->integer("spl");
            $table->integer("vel");
            $table->integer("acc");
            $table->integer("evs");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pokemon');
    }
}
