<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateKeywordsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keywords', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->double('relevance');
            $table->smallInteger('sentiment')->nullable();

            $table->bigInteger('tweet_id', false, true);
            $table->foreign('tweet_id')->references('id')->on('tweets');
            
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
        Schema::drop('keywords');
    }
}
