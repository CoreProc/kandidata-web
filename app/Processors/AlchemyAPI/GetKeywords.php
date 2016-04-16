<?php


namespace KandiData\Processors\AlchemyAPI;


use Exception;
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
                'apikey'    => config('extapis.keywords.api_key'),
                'text'       => $text,
                'outputMode' => config('extapis.output')
            ]
        ]);

        $obj = \GuzzleHttp\json_decode($response->getBody()->getContents());

        try {
            $this->result = new TextKeywords($text, $obj->keywords);
        } catch (Exception $e) {
            \Log::alert($e->getMessage());
            $this->result = new TextKeywords($text, []);
        }
    }
}
