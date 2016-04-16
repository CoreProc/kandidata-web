<?php


namespace KandiData\Processors\Twitter;

use Geocoder\Provider\BingMaps;
use Geocoder\Provider\Chain;
use Geocoder\Provider\GoogleMaps;
use Geocoder\Provider\MapQuest;
use Geocoder\Provider\OpenCage;
use Geocoder\Provider\OpenStreetMap;
use Geocoder\ProviderAggregator;
use GuzzleHttp\Client;
use Ivory\HttpAdapter\Guzzle6HttpAdapter;

class TweetProcessor {
    public static function getLocation($tweet) {
        if(isset($tweet->geo)) {
            return $tweet->geo->coordinates;
        }

        if(isset($tweet->coordinates)) {
            return $tweet->coordinates->coordinates;
        }

        if(isset($tweet->place)) {
            return $tweet->place->bounding_box->coordinates[0][0][0];
        }

        $adapter = new Guzzle6HttpAdapter(new Client());

        $geocoder = new ProviderAggregator();

        $geocoder->registerProviders([
            new Chain([
                new GoogleMaps(
                    $adapter, 'en-US', 'Manila', true, 'AIzaSyAU116bNq-QtuEHq8KTmbFMas3xh3eiMpI'
                ),
                new BingMaps($adapter, 'Ahviv49YoXXaCtNalrA52ykqH4Q51SXlnMR1-klFGLNHgFbqeomjaUvUsxaaZR8n'),
                new MapQuest($adapter, 'Fmjtd%7Cluu821u1ll%2C7l%3Do5-94ba0w'),
                new OpenCage($adapter, '5c6e0a176c574400376cec25f10277a0'),
                new OpenStreetMap($adapter)
            ]),
        ]);

        try {
            $result = $geocoder->geocode($tweet->user->location)->first();
        } catch (\Exception $e) {
            return null;
        }

        $lt = [$result->getLatitude(), $result->getLongitude()];

        return isset($lt) ?: null;
    }
}
