'use strict';

angular.module('kandidata')
    .controller('HomeController', [
        '$rootScope',
        function ($rootScope) {
            var vm = this;

            function initialize() {
                $rootScope.pageClass = 'home-page';
            }

            initialize();
        }
    ]);
