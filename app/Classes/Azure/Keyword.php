<?php


namespace KandiData\Classes\Azure;


class Keyword {
    public $text;
    public $relevance;

    public function __construct($text)
    {
        $this->text      = $text;
        $this->relevance = 0;
    }
}
