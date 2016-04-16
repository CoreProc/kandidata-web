<?php


namespace KandiData\Processors;

use Twitter;

class GetTweet {
    public function __construct($tweet_id)
    {
        $this->tweet_id = $tweet_id;

        $this->tweet_obj = Twitter::getTweet($tweet_id);
    }
}
