<?php

namespace KandiData\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use KandiData\Classes\Twitter\Tweet;
use KandiData\Tweet as KandiDataTweet;
use KandiData\Processors\Twitter\TweetProcessor;
use Twitter;

class CollectTweets extends Job implements ShouldQueue {
    use InteractsWithQueue, SerializesModels;

    protected $tag;
    protected $candidate_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($tag, $candidate_id)
    {
        $this->tag          = $tag;
        $this->candidate_id = $candidate_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $flag = false;

        do {
            $latest_tweet = KandiDataTweet::where('candidate_id', $this->candidate_id)->orderBy('twitter_ident', 'desc')->first();

            $since_id = isset($latest_tweet) ? $latest_tweet->twitter_ident : '';

            $tweets = Twitter::getSearch(['q' => $this->tag, 'count' => 100, 'since_id' => $since_id, 'lang' => 'en']);

            foreach ($tweets->statuses as $tweet) {
                $loc = TweetProcessor::getLocation($tweet);

                $t = new Tweet($tweet->id, $tweet->text, $loc[0], $loc[1], $tweet->created_at);

                \KandiData\Tweet::create([
                    'twitter_ident' => $t->id,
                    'text'          => $t->text,
                    'tweet_date'    => $t->created_at,
                    'lat'           => $t->latitude,
                    'long'          => $t->longitude,
                    'candidate_id'  => $this->candidate_id
                ]);

                $flag = !empty($tweet->search_metadata->next_results);
            }
        } while ($flag);
    }
}
