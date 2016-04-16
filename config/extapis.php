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

    'alt' => [
        'azure' => [
            'base_url' => 'https://api.datamarket.azure.com/data.ashx/amla/text-analytics/v1/GetSentiment',
            'api_key' => env('AZURE_TEXT_ANALYSIS_API_KEY', '')
        ],
        'vivekn' => [
            'base_url' => 'https://community-sentiment.p.mashape.com/text',
            'api_key' => env('MASHAPE_API_KEY', '')
        ]
    ],

    'output' => 'json'
];
