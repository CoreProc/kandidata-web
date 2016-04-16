<?php


namespace KandiData\Processors\Azure;


use Exception;
use KandiData\Classes\AlchemyAPI\TextSentiment;

class GetSentiment {
    public $result;

    public function __construct($text)
    {
        $client = new \GuzzleHttp\Client();

        $response = $client->post(config('extapis.alt.azure.base_url'), [
            'headers'     => [
                'Authorization' => base64_encode('AccountKey:' . config('extapis.alt.azure.api_key')),
                'Accept'        => 'application/json'
            ],
            'form_params' => [
                'text' => $text,
            ]
        ]);

        $obj = \GuzzleHttp\json_decode($response->getBody()->getContents());

        try {
            $this->result = new TextSentiment($text, ($obj->score > .5) ? 1 : -1, $obj->score);
        } catch (Exception $e) {
            \Log::info($e->getMessage());
            $this->result = new TextSentiment($text, null, 0);
        }
    }
}
