<?php


namespace KandiData\Classes\Twitter;


use Carbon\Carbon;

class Tweet {
    public $id;
    public $text;
    public $latitude;
    public $longitude;
    public $created_at;

    public function __construct($id, $text, $latitude, $longitude, $created_at)
    {
        $this->id         = (string)$id;
        $this->text       = (string)$text;
        $this->latitude   = (string)$latitude;
        $this->longitude  = (string)$longitude;
        $this->created_at = new Carbon($created_at);
    }
}
