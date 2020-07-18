<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTematicaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tematica', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->boolean('habilitado')->default('true');
            $table->integer('id_unidad_academica')->unsigned();
            $table->foreign('id_unidad_academica')->references('id')->on('unidad_academica')->onDelete('cascade');
            $table->integer('id_tipo_convocatoria')->unsigned();
            $table->foreign('id_tipo_convocatoria')->references('id')->on('tipo_convocatoria')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('area_calificacion', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->boolean('habilitado')->default('true');
            $table->integer('id_unidad_academica')->unsigned();
            $table->foreign('id_unidad_academica')->references('id')->on('unidad_academica')->onDelete('cascade');
            $table->integer('id_tipo_convocatoria')->unsigned();
            $table->foreign('id_tipo_convocatoria')->references('id')->on('tipo_convocatoria')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('porcentaje', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_requerimiento');
            $table->foreign('id_requerimiento')->references('id')->on('requerimiento')->onDelete('cascade');
            $table->integer('id_auxiliatura');
            $table->foreign('id_auxiliatura')->references('id')->on('auxiliatura')->onDelete('cascade');
            $table->integer('id_tematica');
            $table->foreign('id_tematica')->references('id')->on('tematica')->onDelete('cascade'); 
            $table->integer('id_area');
            $table->foreign('id_area')->references('id')->on('area_calificacion')->onDelete('cascade'); 
            $table->integer('porcentaje');

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
        Schema::dropIfExists('porcentaje');
        Schema::dropIfExists('area_calificacion');
        Schema::dropIfExists('tematica');
    }
}
