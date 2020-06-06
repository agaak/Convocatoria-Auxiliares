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
        Schema::create('tipo_rol_evaluador', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->timestamps();
        });
        
        Schema::create('evaluador', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_tipo_evaluador');
            $table->integer('ci');
            $table->string('nombre');
            $table->string('apellido');
            $table->string('correo');
            $table->string('correo_alt')->nullable();
            $table->timestamps();
        });

        Schema::create('tipo_evaluador', function (Blueprint $table) {
            $table->integer('id_rol_evaluador');
            $table->foreign('id_rol_evaluador')->references('id')->on('tipo_rol_evaluador')->onDelete('cascade');
            $table->integer('id_evaluador');
            $table->foreign('id_evaluador')->references('id')->on('evaluador')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('evaluador_conovocatoria', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_evaluador');
            $table->foreign('id_evaluador')->references('id')->on('evaluador')->onDelete('cascade');
            $table->integer('id_convocatoria');
            $table->foreign('id_convocatoria')->references('id')->on('convocatoria')->onDelete('cascade');
            
            $table->timestamps();
        });

        Schema::create('evaluador_tematica', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_evaluador');
            $table->foreign('id_evaluador')->references('id')->on('evaluador')->onDelete('cascade');
            $table->integer('id_tematica');
            $table->foreign('id_tematica')->references('id')->on('tematica')->onDelete('cascade');
            
            $table->timestamps();
        });

        Schema::create('evaluador_auxiliatura', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_evaluador');
            $table->foreign('id_evaluador')->references('id')->on('evaluador')->onDelete('cascade');
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
        Schema::dropIfExists('tipo_evaluador');
        Schema::dropIfExists('evaluador');
        Schema::dropIfExists('tipo_rol_evaluador');
    }
}
