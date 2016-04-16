<?php


namespace KandiData\Processors;


use Carbon\Carbon;

class TweetProcessor {
    public function __construct($from, $to)
    {
        $this->from = new Carbon($from);
        $this->to   = new Carbon($to);
    }

    public function process() {
        
    }
}
