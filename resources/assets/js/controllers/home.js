'use strict';

angular.module('kandidata')
    .controller('HomeController', [
        '$rootScope',
        'session',
        'api',
        function ($rootScope, session, api) {
            var vm = this;
            vm.candidates = null;

            function initialize() {
                $rootScope.pageClass = 'home-page';
                $rootScope.title = 'KandiData | A data-driven Web App for Twitter metrics for the Philippines Election 2016 presidential candidates';

                vm.candidates = session.getCandidates();

            }

            initialize();
        }
    ]);
