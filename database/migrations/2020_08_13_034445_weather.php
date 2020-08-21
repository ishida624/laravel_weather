<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Weather extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weather', function (Blueprint $table) {
            $table->id();
            $table->integer('city_id', false, false);
            $table->char('weather', 10);
            $table->integer('temper', false, false);
            $table->integer('temp_feel', false, false);
            $table->integer('temp_max', false, false);
            $table->integer('temp_min', false, false);
            $table->date('sunrise');
            $table->date('sunset');
            $table->integer('week');
            $table->timestamp('update_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
