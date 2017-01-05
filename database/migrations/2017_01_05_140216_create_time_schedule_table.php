<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_schedule' ,function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('schedule_id');
            $table->integer('no');
            $table->string('place_id');
            $table->time('departing_at');
            $table->boolean('is_arrival');
            $table->primary(['schedule_id', 'no', 'place_id']);
            $table->foreign('place_id')->references('id')->on('place')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('schedule_id')->references('id')->on('schedule')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::drop('time_schedule');
    }
}
