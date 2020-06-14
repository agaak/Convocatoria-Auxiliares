<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostulanteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_postulante', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_convocatoria');
            $table->string('nombre');
            $table->string('apellido');
            $table->string('direccion');
            $table->string('correo');
            $table->string('cod_sis');
            $table->integer('telefono');
            $table->integer('ci');
            $table->timestamps();

            $table->foreign('id_convocatoria')->references('id')->on('convocatoria')->onDelete('cascade');
        });

        Schema::create('pre_postulante_auxiliatura', function (Blueprint $table) {
            $table->integer('id_pre_postulante');
            $table->foreign('id_pre_postulante')->references('id')->on('pre_postulante')->onDelete('cascade');
            $table->integer('id_auxiliatura');
            $table->foreign('id_auxiliatura')->references('id')->on('auxiliatura')->onDelete('cascade');
            $table->string('observacion');
            $table->timestamps();
        });

        Schema::create('postulante', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('apellido');
            $table->string('carrera');
            $table->string('correo');
            $table->integer('ci');
            $table->timestamps();
        });

        Schema::create('postulante_auxiliatura', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_postulante');
            $table->foreign('id_postulante')->references('id')->on('postulante')->onDelete('cascade');
            $table->integer('id_auxiliatura');
            $table->foreign('id_auxiliatura')->references('id')->on('auxiliatura')->onDelete('cascade');
            $table->string('observacion');
            $table->boolean('habilitado',false);
            $table->timestamps();
        });

        Schema::create('postulante_conovocatoria', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_postulante');
            $table->foreign('id_postulante')->references('id')->on('postulante')->onDelete('cascade');
            $table->integer('id_convocatoria');
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
        Schema::dropIfExists('postulante_conovocatoria');
        Schema::dropIfExists('postulante_auxiliatura');
        Schema::dropIfExists('postulante');
        Schema::dropIfExists('pre_postulante_auxiliatura');
        Schema::dropIfExists('pre_postulante');
    }
}
