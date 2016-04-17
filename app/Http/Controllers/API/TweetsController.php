<?php

namespace KandiData\Http\Controllers\API;

use Illuminate\Http\Request;
use KandiData\Http\Controllers\Controller;
use KandiData\Http\Requests;
use KandiData\Tweet;

class TweetsController extends Controller {
    public function index(Request $request)
    {
        $all          = $request->has('all');
        $candidate_id = $request->get('candidate_id');

        $tweets = $all ? (new Tweet) : Tweet::withData();

        return response($tweets->candidate($candidate_id)->with('keywords')->orderBy('tweet_date', 'desc')->paginate());
    }
}
