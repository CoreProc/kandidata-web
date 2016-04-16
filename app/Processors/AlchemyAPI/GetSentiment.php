<?php


namespace KandiData\Processors\AlchemyAPI;


use Exception;
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
        $client = new \GuzzleHttp\Client();

        $response = $client->post(config('extapis.sentiment.base_url'), [
            'form_params' => [
                'apikey'    => config('extapis.sentiment.api_key'),
                'text'       => "RT @AlxJst: Duterte is good but Miriam is better and she can even do best despite of her health condition. #BestChoice #MIRIAM2016",
                'outputMode' => config('extapis.output')
            ]
        ]);

        $obj = \GuzzleHttp\json_decode($response->getBody()->getContents());

        try {
            $this->result = new TextSentiment($text, $obj->docSentiment->type, $obj->docSentiment->score);
        } catch (Exception $e) {
            \Log::alert($e->getMessage());
            $this->result = new TextSentiment($text, null, 0);
        }
    }
}
