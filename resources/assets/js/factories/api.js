'use strict';

angular.module('kandidata')
    .factory('api', [
        '$http',
        function ($http) {
            var api = this;
            var endpoint = 'https://www.kandidata.tech/api/';

            api.getCandidates = function () {
                return $http.get(endpoint + 'candidates');
            };

            api.getSentiment = function (id, from) {
                return $http.get(endpoint + id + '/sentiments?from=' + from);
            };

            api.getFeels = function (id) {
                return $http.get(endpoint + id + '/feels');
            };

            api.getKeywords = function (id) {
                return $http.get(endpoint + id + '/keywords');
            };

            api.getFeelsTweets = function (id, feels) {
                return $http.get(endpoint + id + '/tweet-feels?feels=' + feels);
            };

            api.getTweets = function (id) {
                return $http.get(endpoint + 'tweets?candidate_id=' + id);
            };
            return api;
        }
    ]);
