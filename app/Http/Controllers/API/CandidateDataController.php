<?php


namespace KandiData\Http\Controllers\API;


use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use KandiData\Candidate;
use KandiData\Http\Controllers\Controller;
use KandiData\Keyword;
use KandiData\Tweet;

class CandidateDataController extends Controller {
    public function getCandidates()
    {
        return Candidate::all();
    }

    public function getSentiments(Request $request, $candidate_id)
    {
        try {
            $dateFrom = new Carbon($request->get('from'));
            $dateTo   = new Carbon($request->get('to'));
        } catch (Exception $e) {
            $dateFrom = new Carbon('2016-04-15 00:00:00');
            $dateTo   = Carbon::now();
        }

        $period = $request->get('period', 'HOUR');

        $this->validate($request, [
            'period' => 'in:HOUR,MINUTE,DAY,MONTH,YEAR',
        ]);

        $tweets = DB::table((new Tweet())->getTable())
                    ->select([DB::raw('count(id) as `count`'), DB::raw("$period(tweet_date) as `period`"), 'sentiment'])
                    ->where('candidate_id', $candidate_id)->whereNotNull('sentiment')->where('sentiment', '!=', 0)
                    ->whereBetween('tweet_date', [$dateFrom, $dateTo])->groupBy('period')->groupBy('sentiment')->get();

        $colle = new Collection($tweets);

        $colle = $colle->groupBy('period');

        $colle->each(function ($tw) {
            foreach ($tw as $t) {
                $t->value = $t->count * $t->sentiment;
            }
        });

        $computed = [];

        foreach ($colle as $c) {
            $value  = 0;
            $period = 0;

            foreach ($c as $x) {
                $value += $x->value;
                $period = $x->period;
            }

            $computed[$period] = [
                'value'  => $value,
                'period' => $period
            ];
        }

        $returned = new Collection(array_values($computed));

        return response($returned);
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
            'anger'   => $sum == 0 ? 0 : round($feels->anger / $sum, 2),
            'joy'     => $sum == 0 ? 0 : round($feels->joy / $sum, 2),
            'disgust' => $sum == 0 ? 0 : round($feels->disgust / $sum, 2),
            'fear'    => $sum == 0 ? 0 : round($feels->fear / $sum, 2),
            'sadness' => $sum == 0 ? 0 : round($feels->sadness / $sum, 2),
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

    public function getTweetFeels(Request $request, $candidate_id)
    {
        $feels = $request->get('feels');

        $this->validate($request, [
            'feels' => 'in:anger,joy,disgust,fear,sadness'
        ]);

        $tweets = Tweet::orderBy('feels_' . $feels, 'desc')->where('candidate_id', $candidate_id)->limit(5)->get();

        return response($tweets);
    }

    public function getTweets(Request $request, $candidate_id)
    {
        $sentiment = $request->get('sentiment', 1);

        $this->validate($request, [
            'sentiment' => 'in:1,-1'
        ]);

        $tweets = Tweet::withSentiment()->candidate($candidate_id)
            ->where('sentiment', $sentiment)->orderBy('tweet_date', 'desc')->paginate();

        return response($tweets);
    }
}
