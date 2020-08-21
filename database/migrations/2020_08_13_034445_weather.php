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
            // $table->integer('city_id', false, false);
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('city');
            $table->char('weather', 32);
            $table->integer('temp', false, false);
            $table->integer('temp_feel', false, false);
            $table->integer('temp_max', false, false);
            $table->integer('temp_min', false, false);
            $table->dateTime('sunrise');
            $table->dateTime('sunset');
            $table->integer('day');
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
