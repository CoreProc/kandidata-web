<?php

namespace KandiData\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use KandiData\Keyword;
use KandiData\Processors\AlchemyAPI\GetKeywords;
use KandiData\Tweet;

class ProcessKeywords extends Job implements ShouldQueue {
    use InteractsWithQueue, SerializesModels;

    protected $tweets;

    /**
     * Create a new job instance.
     *
     * @return void
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
        $this->tweets->doesntHave('keywords')->chunk(100, function ($tweets) {
            foreach ($tweets as $tweet) {
                $alz = new GetKeywords($tweet->text);

                foreach ($alz->result->keywords as $keyword) {
                    $keyword = new Keyword([
                        'name'      => $keyword->text,
                        'relevance' => $keyword->relevance
                    ]);

                    $tweet->keyword()->save($keyword);
                }
            }
        });
    }
}
