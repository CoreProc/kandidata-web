<?php

namespace KandiData\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use KandiData\Processors\AlchemyAPI\GetSentiment;
use KandiData\Tweet;

class ProcessSentiments extends Job implements ShouldQueue {
    use InteractsWithQueue, SerializesModels;

    protected $tweets;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Tweet::whereNull('sentiment')->chunk(100, function ($tweets) {
            foreach ($tweets as $tweet) {
                $alz = new GetSentiment($tweet->text);
                
                $tweet->sentiment       = $alz->result->type;
                $tweet->sentiment_score = $alz->result->score;
                $tweet->save();
            }
        });
    }
}
