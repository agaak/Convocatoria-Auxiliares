<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalificacionFinalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calificacion_final', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_auxiliatura')->unsigned();

            $table->foreign('id_auxiliatura')->references('id')->on('auxiliatura')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('calificacion_merito', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_calf_fin')->unsigned();
            $table->integer('porcentaje');

            $table->foreign('id_calf_fin')->references('id')->on('calificacion_final')->onDelete('cascade');
            $table->timestamps();
        });

        // Schema::create('merito', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('id_calf_merito')->unsigned();
        //     $table->integer('id_mer_prin')->unsigned();
        //     $table->text('descripcion');
        //     $table->integer('porcentaje');
            
        //     $table->foreign('id_calf_merito')->references('id')->on('calificacion_merito')->onDelete('cascade');
        //     $table->foreign('id_mer_prin')->references('id')->on('merito')->onDelete('cascade');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('merito');
        Schema::dropIfExists('calificacion_merito');
        Schema::dropIfExists('calificacion_final');
    }
}
