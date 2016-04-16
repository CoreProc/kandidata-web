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

            return api;
        }
    ]);
