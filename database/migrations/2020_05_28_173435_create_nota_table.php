<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_tipo_nota');
            $table->integer('id_convocatoria');
            $table->text('descripcion');

            $table->foreign('id_convocatoria')->references('id')->on('convocatoria')->onDelete('cascade');
            $table->foreign('id_tipo_nota')->references('id')->on('tipo_nota')->onDelete('cascade');
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
        Schema::dropIfExists('nota');
    }
}
