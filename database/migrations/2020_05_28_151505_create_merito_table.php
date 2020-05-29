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
            $table->integer('id_submerito')->nullable();
            $table->string('descripcion_merito');
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
        Schema::dropIfExists('merito');
    }
}
