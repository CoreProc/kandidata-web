<?php


namespace KandiData\Processors\AlchemyAPI;


use Exception;
use GuzzleHttp\Client;
use KandiData\Classes\AlchemyAPI\TextFeels;

/**
 * Class GetFeels
 *
 * @package KandiData\Processors\AlchemyAPI
 */
class GetFeels {
    /**
     * @var \KandiData\Classes\AlchemyAPI\TextFeels
     */
    public $result;

    /**
     * GetFeels constructor.
     *
     * @param $text
     */
    public function __construct($text)
    {
        $client = new Client();

        $response = $client->post(config('extapis.feels.base_url'), [
            'form_params' => [
                'apikey'     => config('extapis.feels.api_key'),
                'text'       => $text,
                'outputMode' => config('extapis.output')
            ]
        ]);

        $obj = \GuzzleHttp\json_decode($response->getBody()->getContents());

        try {
            $this->result = new TextFeels($text,
                $obj->docEmotions->anger,
                $obj->docEmotions->disgust,
                $obj->docEmotions->fear,
                $obj->docEmotions->joy,
                $obj->docEmotions->sadness);
        } catch (Exception $e) {
            $this->result = new TextFeels($text,
                0,
                0,
                0,
                0,
                0);
        }

    }
}
