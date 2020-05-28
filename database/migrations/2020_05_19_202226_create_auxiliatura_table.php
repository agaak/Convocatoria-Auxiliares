<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuxiliaturaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auxiliatura', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_unidad_academica')->unsigned();
            $table->foreign('id_unidad_academica')->references('id')->on('unidad_academica')->onDelete('cascade');
            $table->text('nombre_aux');
            $table->string('cod_aux',12);

            $table->timestamps();
        });

        Schema::create('porcentaje', function (Blueprint $table) {
            $table->integer('id_convocatoria');
            $table->integer('id_auxliatura');
            $table->integer('id_tematica');
            $table->integer('porncentaje');

            $table->foreign('id_convocatoria')->references('id')->on('convocatoria')->onDelete('cascade');
            $table->foreign('id_auxliatura')->references('id')->on('auxliatura')->onDelete('cascade');
            $table->foreign('id_tematica')->references('id')->on('tematica')->onDelete('cascade');            
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
        Schema::dropIfExists('auxiliatura');
    }
}
