<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArrivalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arrival' ,function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('schedule_id');
            $table->integer('no');
            $table->string('place_id');
            $table->time('arrival_at');
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
        Schema::drop('arrival');
    }
}
