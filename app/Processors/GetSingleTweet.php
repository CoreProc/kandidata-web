<?php


namespace KandiData\Processors;

use Exception;
use Twitter;

class GetSingleTweet {
    public $tweet_obj;

    public function __construct($tweet_id)
    {
        $this->tweet_id = $tweet_id;

        try {
            $this->tweet_obj = Twitter::getTweet($tweet_id);
        } catch (Exception $e) {
            $this->tweet_obj = null;
        }
    }
}
