<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTweetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tweets', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('tweet_id');
            $table->string('text');
            $table->smallInteger('sentiment');
            $table->json('feels');
            $table->json('keywords');
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->dateTime('tweet_date');

            $table->integer('candidate_id', false, true);
            $table->foreign('candidate_id')->references('id')->on('candidates');

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
        Schema::drop('tweets');
    }
}
