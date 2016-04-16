<?php


namespace KandiData\Processors\AlchemyAPI;


use GuzzleHttp\Client;
use KandiData\Classes\AlchemyAPI\TextKeywords;

/**
 * Class GetKeywords
 *
 * @package KandiData\Processors\AlchemyAPI
 */
class GetKeywords {
    /**
     * @var \KandiData\Classes\AlchemyAPI\TextKeywords
     */
    public $result;

    /**
     * GetKeywords constructor.
     *
     * @param $text
     */
    public function __construct($text)
    {
        $client = new Client();

        $response = $client->post(config('extapis.keywords.base_url'), [
            'form_params' => [
                'api_key'    => config('extapis.keywords.api_key'),
                'text'       => $text,
                'outputMode' => config('extapis.output')
            ]
        ]);

        $obj = \GuzzleHttp\json_decode($response->getBody()->getContents());

        $this->result = new TextKeywords($text, $obj->keywords);
    }
}
