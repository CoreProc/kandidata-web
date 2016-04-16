'use strict';

angular.module('kandidata')
    .service('session', [
        function () {
            var candidates = null;

            function getCandidates() {
                return candidates;
            }

            function storeCandidates(obj) {
                candidates = obj;
            }

            return {
                getCandidates: getCandidates,
                storeCandidates: storeCandidates
            }
        }
    ]);
