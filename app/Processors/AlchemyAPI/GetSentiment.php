<?php


namespace KandiData\Processors\AlchemyAPI;


use GuzzleHttp\Client;
use KandiData\Classes\AlchemyAPI\TextSentiment;

/**
 * Class GetSentiment
 *
 * @package KandiData\Processors\AlchemyAPI
 */
class GetSentiment {
    /**
     * @var \KandiData\Classes\AlchemyAPI\TextSentiment
     */
    public $result;

    /**
     * GetSentiment constructor.
     *
     * @param $text
     */
    public function __construct($text)
    {
        $client = new Client();

        $response = $client->post(config('extapis.sentiment.base_url'), [
            'form_params' => [
                'api_key'    => config('extapis.sentiment.api_key'),
                'text'       => $text,
                'outputMode' => config('extapis.output')
            ]
        ]);

        $obj = \GuzzleHttp\json_decode($response->getBody()->getContents());

        $this->result = new TextSentiment($text, $obj->docSentiment->type, $obj->docSentiment->score);
    }
}
