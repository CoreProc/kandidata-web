<?php


namespace KandiData\Processors\Azure;


use Exception;
use KandiData\Classes\Azure\TextSentiment;

class GetSentiment {
    public $result;

    public function __construct($text)
    {
        $client = new \GuzzleHttp\Client();

        $response = $client->get(config('extapis.alt.azure.base_url'), [
            'headers'     => [
                'Authorization' => 'Basic ' . base64_encode('AccountKey:' . config('extapis.alt.azure.api_key')),
                'Accept'        => 'application/json'
            ],
            'query' => [
                'text' => $text,
            ]
        ]);

        $obj = \GuzzleHttp\json_decode($response->getBody()->getContents());

        try {
            $this->result = new TextSentiment($text, ($obj->Score > .5) ? 1 : -1, $obj->Score);
        } catch (Exception $e) {
            \Log::info($e->getMessage());
            $this->result = new TextSentiment($text, null, 0);
        }
    }
}
