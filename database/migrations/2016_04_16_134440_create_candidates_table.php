<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name');
            
            $table->string('hashtag');
            $table->string('twitter_mention');
            
            $table->integer('position_id', false, true);
            $table->foreign('position_id')->references('id')->on('positions');
            
            $table->integer('period_id', false, true);
            $table->foreign('period_id')->references('id')->on('periods');
            
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
        Schema::drop('candidates');
    }
}
