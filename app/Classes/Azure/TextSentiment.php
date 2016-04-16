<?php


namespace KandiData\Classes\Azure;


class TextSentiment {
    const POSITIVE = 1;
    const NEGATIVE = -1;

    public $type;
    public $score;
    public $text;

    public function __construct($text, $type, $score)
    {
        $this->text  = (string)$text;
        $this->type  = (int)$type;
        $this->score = (double)$score;
    }
}
