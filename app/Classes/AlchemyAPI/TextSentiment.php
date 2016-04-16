<?php


namespace KandiData\Classes\AlchemyAPI;


class TextSentiment {
    const POSITIVE = 'positive';
    const NEGATIVE = 'negative';
    const NEUTRAL  = 'neutral';

    public $type = null;
    public $score;
    public $text;

    public function __construct($text, $type, $score)
    {
        $this->text = (string)$text;

        switch ($type) {
            case self::POSITIVE:
                $this->type = 1;
                break;
            case self::NEGATIVE:
                $this->type = -1;
                break;
            case self::NEUTRAL:
                $this->type = 0;
                break;
        }

        $this->score = (double)$score;
    }
}
