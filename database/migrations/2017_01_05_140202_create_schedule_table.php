<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule' ,function (Blueprint $table) {
            $table->string('id')->unique();
            $table->string('title');
            $table->dateTime('startDate')->nullable();
            $table->dateTime('endDate')->nullable();
            $table->boolean('isDefault');
            $table->boolean('isStopWeekend');
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
        Schema::drop('schedule');
    }
}
