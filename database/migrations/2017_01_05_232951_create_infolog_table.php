<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInfologTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infolog' ,function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('id');
            $table->string('name');
            $table->integer('status');
            $table->boolean('is_topAlert');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->primary(['id']);
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
        Schema::drop('infolog');
    }
}
