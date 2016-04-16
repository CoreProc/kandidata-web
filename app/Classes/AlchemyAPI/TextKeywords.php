<?php


namespace KandiData\Classes\AlchemyAPI;


class TextKeywords {
    public $text;
    public $keywords = [];

    public function __construct($text, $keywords = [])
    {
        $this->text      = $text;
        
        foreach ($keywords as $keyword) {
            $this->keywords[] = new Keyword($keyword->text, $keyword->relevance);
        }
    }
    
}
