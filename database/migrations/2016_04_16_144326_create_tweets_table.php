<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTweetsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tweets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('twitter_ident');
            $table->string('text');
            $table->smallInteger('sentiment')->nullable();
            $table->string('sentiment_score')->nullable();
            $table->json('feels')->nullable();
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
