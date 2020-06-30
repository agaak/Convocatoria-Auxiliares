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
            $table->integer('id_tipo_convocatoria')->unsigned();
            $table->foreign('id_tipo_convocatoria')->references('id')->on('tipo_convocatoria')->onDelete('cascade');
            $table->boolean('habilitado')->default('true');
            $table->text('nombre_aux');
            $table->string('cod_aux',12);

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
        Schema::dropIfExists('auxiliatura');
    }
}
