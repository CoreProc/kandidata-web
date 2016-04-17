<?php

namespace KandiData\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use KandiData\Keyword;
use KandiData\Processors\Azure\GetKeywords;
use KandiData\Tweet;

class ProcessKeywords extends Job implements ShouldQueue {
    use InteractsWithQueue, SerializesModels;

    protected $tweets;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Tweet::doesntHave('keywords')->chunk(100, function ($tweets) {
            foreach ($tweets as $tweet) {
                $alz = new GetKeywords($tweet->text);

                if (!empty($alz->result->keywords)) {
                    foreach ($alz->result->keywords as $keyword) {
                        $key = new Keyword;
                        $key->fill([
                            'name'         => $keyword->text,
                            'relevance'    => $keyword->relevance,
                            'candidate_id' => $tweet->candidate_id
                        ]);

                        $tweet->keywords()->save($key);
                    }
                }
            }
        });
    }
}
