<?php


namespace KandiData\Http\Controllers\API;


use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use KandiData\Http\Controllers\Controller;
use KandiData\Keyword;
use KandiData\Tweet;

class CandidateDataController extends Controller {
    public function getSentiments(Request $request, $candidate_id)
    {
        $dateFrom = new Carbon($request->get('from', '2016-04-16 00:00:00'));
        $dateTo   = new Carbon($request->get('to', Carbon::now()));
        $period   = $request->get('period', 'HOUR');

        $tweets = DB::table((new Tweet())->getTable())
                    ->select([DB::raw('count(id) as `count`'), DB::raw("$period(tweet_date) as `period`"), 'sentiment'])
                    ->where('candidate_id', $candidate_id)
                    ->whereBetween('tweet_date', [$dateFrom, $dateTo])->groupBy('period')->groupBy('sentiment')->get();

        $colle = new Collection($tweets);

        $colle->each(function($tw) {
            $tw->value = $tw->count * $tw->sentiment;
        });

        return response($tweets);
    }

    public function getFeels($candidate_id)
    {
        $feels = DB::table((new Tweet())->getTable())
                   ->select([
                       DB::raw('sum(feels_anger) as anger'),
                       DB::raw('sum(feels_joy) as joy'),
                       DB::raw('sum(feels_disgust) as disgust'),
                       DB::raw('sum(feels_fear) as fear'),
                       DB::raw('sum(feels_sadness) as sadness'),
                   ])->where('candidate_id', $candidate_id)->first();

        $sum = $feels->anger + $feels->joy + $feels->disgust + $feels->fear + $feels->sadness;

        return response([
            'anger'   => round($feels->anger / $sum, 2),
            'joy'     => round($feels->joy / $sum, 2),
            'disgust' => round($feels->disgust / $sum, 2),
            'fear'    => round($feels->fear / $sum, 2),
            'sadness' => round($feels->sadness / $sum, 2),
        ]);
    }

    public function getKeywords($candidate_id)
    {
        $keywords = DB::table((new Keyword())->getTable())
                      ->select([
                          DB::raw('count(id) as `count`'), 'name', 'relevance'
                      ])->where('candidate_id', $candidate_id)->groupBy('name')
                      ->orderBy('count', 'desc')->orderBy('relevance', 'desc')->limit(20)->get();
        
        return response($keywords);
    }
}
