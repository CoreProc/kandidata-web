<?php


namespace KandiData\Classes\AlchemyAPI;


class Keyword {
    public $text;
    public $relevance;

    public function __construct($text, $relevance)
    {
        $this->text      = $text;
        $this->relevance = $relevance;
    }
}
