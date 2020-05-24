<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportantEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('important_events', function (Blueprint $table) {
            $table->increments('id_important_events');
            $table->string('title_event');
            $table->string('place_event');
            $table->date('date_ini');
            $table->date('date_fin');
            $table->time('time_ini');
            $table->time('time_fin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('important_events');
    }
}
