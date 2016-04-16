<?php


namespace KandiData\Classes\AlchemyAPI;


class TextFeels {
    public $anger;   // >:(
    public $disgust; // >__>
    public $fear;    // :O
    public $joy;     // :)
    public $sadness; // :(

    public function __construct($text, $anger, $disgust, $fear, $joy, $sadness /* so what's the point, in all of this */)
    {
        $this->text    = $text;
        $this->anger   = $anger;
        $this->joy     = $joy;
        $this->disgust = $disgust;
        $this->fear    = $fear;
        $this->sadness = $sadness;
    }
}
