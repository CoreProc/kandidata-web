<?php


namespace KandiData\Processors\Azure;


use Exception;
use GuzzleHttp\Client;
use KandiData\Classes\Azure\TextKeywords;

/**
 * Class GetKeywords
 *
 * @package KandiData\Processors\Azure
 */
class GetKeywords {
    /**
     * @var \KandiData\Classes\Azure\TextKeywords
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

        $response = $client->get(config('extapis.alt.azure.base_url') . '/GetKeyPhrases', [
            'headers'     => [
                'Authorization' => 'Basic ' . base64_encode('AccountKey:' . config('extapis.alt.azure.api_key')),
                'Accept'        => 'application/json'
            ],
            'query' => [
                'text' => $text,
            ],
        ]);

        $obj = \GuzzleHttp\json_decode($response->getBody()->getContents());

        try {
            $this->result = new TextKeywords($text, $obj->KeyPhrases);
        } catch (Exception $e) {
            \Log::alert($e->getMessage());
            $this->result = new TextKeywords($text, []);
        }
    }
}
