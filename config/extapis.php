<?php

return [
    'sentiment' => [
        'base_url' => 'http://gateway-a.watsonplatform.net/calls/text/TextGetTextSentiment',
        'api_key' => env('ALCHEMYAPI_API_KEY', '')
    ],

    'feels' => [
        'base_url' => 'http://gateway-a.watsonplatform.net/calls/text/TextGetEmotion',
        'api_key' => env('ALCHEMYAPI_API_KEY', '')
    ],

    'keywords' => [
        'base_url' => 'http://gateway-a.watsonplatform.net/calls/text/TextGetRankedKeywords',
        'api_key' => env('ALCHEMYAPI_API_KEY', '')
    ],

    'output' => 'json'
];
