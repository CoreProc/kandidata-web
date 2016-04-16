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

                vm.candidates = session.getCandidates();

            }

            initialize();
        }
    ]);
