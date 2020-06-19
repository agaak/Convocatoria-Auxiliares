<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalificacionMeritoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calificacion_merito', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_postulante');
            $table->foreign('id_postulante')->references('id')->on('postulante') ->onDelete('cascade');
            $table->integer('id_merito');
            $table->foreign('id_merito')->references('id')->on('merito') ->onDelete('cascade');
            $table->integer('id_calf_final');
            $table->foreign('id_calf_final')->references('id')->on('calf_final_postulante_merito') ->onDelete('cascade');
            $table->integer('calificacion')->nullable();
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
        Schema::dropIfExists('calificacion_merito');
    }
}
