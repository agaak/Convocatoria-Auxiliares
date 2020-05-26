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
            //$table->integer('id_tipo_examen');
            $table->string('tematica');
            //$table->foreign('id_tipo_examen')->references('id')->on('tipo_examen')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('porcentaje', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('porcentaje');
            $table->integer('id_requerimiento')->unsigned();
            $table->integer('id_tematica')->unsigned();
            $table->foreign('id_requerimiento')->references('id')->on('requerimiento')->onDelete('cascade');
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
        Schema::dropIfExists('tematica');
    }
}
