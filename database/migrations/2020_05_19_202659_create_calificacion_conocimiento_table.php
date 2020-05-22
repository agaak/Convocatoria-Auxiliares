<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalificacionConocimientoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calificacion_conocimiento', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_calf_fin')->unsigned();
            $table->integer('porcentaje_conocimientos');
            $table->integer('porcentaje_total');

            $table->foreign('id_calf_fin')->references('id')->on('calificacion_final')->onDelete('cascade');
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
        Schema::dropIfExists('calificacion_conocimiento');
    }
}
