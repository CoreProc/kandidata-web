<?php

namespace KandiData\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use KandiData\Processors\AlchemyAPI\GetFeels;
use KandiData\Tweet;

class ProcessFeels extends Job implements ShouldQueue {
    use InteractsWithQueue, SerializesModels;

    protected $tweets;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Tweet::whereNull('feels_anger')->chunk(100, function ($tweets) {
            foreach ($tweets as $tweet) {
                $alz = new GetFeels($tweet->text);

                $tweet->feels_anger   = $alz->result->anger;
                $tweet->feels_disgust = $alz->result->disgust;
                $tweet->feels_joy     = $alz->result->joy;
                $tweet->feels_fear    = $alz->result->fear;
                $tweet->feels_sadness = $alz->result->sadness;

                $tweet->save();
            }
        });
    }
}
