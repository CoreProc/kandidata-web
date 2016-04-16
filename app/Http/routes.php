<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('master');
});

Route::group(['prefix' => 'api'], function () {
    Route::get('{id}/sentiments', 'API\CandidateDataController@getSentiments');
    Route::get('{id}/feels', 'API\CandidateDataController@getFeels');
    Route::get('{id}/keywords', 'API\CandidateDataController@getKeywords');
});
