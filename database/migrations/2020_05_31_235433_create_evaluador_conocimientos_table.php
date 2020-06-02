<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluadorConocimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluador_conocimientos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ci');
            $table->string('nombre');
            $table->string('apellido');
            $table->string('correo');
            $table->timestamps();
        });

        Schema::create('evaluador_conovocatoria', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_evaluador');
            $table->foreign('id_evaluador')->references('id')->on('postulante')->onDelete('cascade');
            $table->integer('id_convocatoria');
            $table->foreign('id_convocatoria')->references('id')->on('convocatoria')->onDelete('cascade');
            
            $table->timestamps();
        });

        Schema::create('evaluador_tematica', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_evaluador');
            $table->foreign('id_evaluador')->references('id')->on('postulante')->onDelete('cascade');
            $table->integer('id_tematica');
            $table->foreign('id_tematica')->references('id')->on('tematica')->onDelete('cascade');
            
            $table->timestamps();
        });

        Schema::create('evaluador_auxiliatura', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_evaluador');
            $table->foreign('id_evaluador')->references('id')->on('postulante')->onDelete('cascade');
            $table->integer('id_auxiliatura');
            $table->foreign('id_auxiliatura')->references('id')->on('auxiliatura')->onDelete('cascade');
            
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
        Schema::dropIfExists('evaluador_auxiliatura');
        Schema::dropIfExists('evaluador_tematica');
        Schema::dropIfExists('evaluador_conovocatoria');
        Schema::dropIfExists('evaluador_conocimientos');
    }
}