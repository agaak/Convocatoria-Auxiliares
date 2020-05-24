<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequerimientoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requerimiento', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_convocatoria')->unsigned();
            $table->string('nombre');
            $table->integer('item');
            $table->integer('cantidad'); 
            $table->integer('horas_mes');
            $table->string('cod_aux',9); 

            $table->foreign('id_convocatoria')->references('id')->on('convocatoria')->onDelete('cascade');
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
        Schema::dropIfExists('requerimiento');
    }
}
