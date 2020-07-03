<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalfConocPostulanteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calif_conoc_post', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_postulante');
            $table->foreign('id_postulante')->references('id')->on('postulante') ->onDelete('cascade');
            $table->integer('id_porcentaje');
            $table->foreign('id_porcentaje')->references('id')->on('porcentaje') ->onDelete('cascade');
            $table->integer('id_calf_final');
            $table->foreign('id_calf_final')->references('id')->on('calf_fin_postulante_conoc') ->onDelete('cascade');
            $table->double('calificacion', 2, 2)->nullable();
            $table->string('estado')->nullable();
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
        Schema::dropIfExists('calif_conoc_post');
    }
}
