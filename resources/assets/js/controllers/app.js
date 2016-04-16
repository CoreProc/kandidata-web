'use strict';

angular.module('kandidata')
    .controller('AppController', [
        'session',
        'api',
        function (session, api) {
            var vm = this;
            vm.isReady = false;

            function initialize() {
                if (session.getCandidates() == null) {
                    api.getCandidates()
                        .then(function (response) {
                           session.storeCandidates(response.data);
                            vm.isReady = true;
                        }, function() {
                            alert('An error has occured.');
                        });
                }
            }

            initialize();
        }
    ]);
