<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeritoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merito', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_convocatoria');
            $table->foreign('id_convocatoria')->references('id')->on('convocatoria')->onDelete('cascade');
            $table->string('descripcion_merito');
            $table->integer('porcentaje');

            $table->timestamps();
        });

        Schema::create('tipo_sub_merito', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion_sub_merito');

            $table->timestamps();
        });

        Schema::create('sub_merito', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_submerito_padre');
            $table->foreign('id_submerito_padre')->references('id')->on('sub_merito')->onDelete('cascade');
            $table->integer('id_tipo');
            $table->foreign('id_tipo')->references('id')->on('tipo_sub_merito')->onDelete('cascade');
            $table->string('descripcion_sub_merito');
            $table->integer('sub_porcentaje');

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
        Schema::dropIfExists('sub_merito');
        Schema::dropIfExists('tipo_sub_merito');
        Schema::dropIfExists('merito');
    }
}
