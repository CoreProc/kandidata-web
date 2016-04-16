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
     * Create a new job instance.
     *
     * @param \KandiData\Tweet $tweets
     */
    public function __construct(Tweet $tweets)
    {
        $this->tweets = $tweets;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->tweets->whereNull('feels')->chunk(100, function($tweets) {
            foreach ($tweets as $tweet) {
                $alz = new GetFeels($tweet->text);

                $tweet->feels = json_encode([
                    'anger'   => $alz->result->anger,
                    'disgust' => $alz->result->disgust,
                    'fear'    => $alz->result->fear,
                    'sadness' => $alz->result->sadness,
                ]);

                $tweet->save();
            }
        });
    }
}
