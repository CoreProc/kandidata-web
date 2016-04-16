'use strict';

angular.module('kandidata')
    .factory('api', [
        '$http',
        function ($http) {
            var api = this;
            var endpoint = '/api/';

            api.getCandidates = function () {
                return $http.get(endpoint + 'candidates');
            };

            api.getSentiment = function (id) {
                return $http.get(endpoint + id + '/sentiments');
            };

            api.getFeels = function (id) {
                return $http.get(endpoint + id + '/feels');
            };

            return api;
        }
    ]);
