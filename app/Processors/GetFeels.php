<?php


namespace KandiData\Processors;


use GuzzleHttp\Client;
use KandiData\Classes\AlchemyAPI\TextFeels;

class GetFeels {
    public $result;

    public function __construct($text)
    {
        $client = new Client();

        $response = $client->post(config('extapis.feels.base_url'), [
            'form_params' => [
                'api_key'    => config('extapis.feels.api_key'),
                'text'       => $text,
                'outputMode' => config('extapis.output')
            ]
        ]);

        $obj = \GuzzleHttp\json_decode($response->getBody()->getContents());

        $this->result = new TextFeels($text,
            $obj->docEmotions->anger,
            $obj->docEmotions->disgust,
            $obj->docEmotions->fear,
            $obj->docEmotions->joy,
            $obj->docEmotions->sadness);

    }


}
