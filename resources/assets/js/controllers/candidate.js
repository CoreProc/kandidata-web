'use strict';

angular.module('kandidata')
    .controller('CandidateController', [
        '$rootScope',
        '$scope',
        '$stateParams',
        '$state',
        '$http',
        function ($rootScope, $scope, $stateParams, $state, $http) {
            var vm = this;

            vm.candidates = [ 'binay', 'santiago', 'duterte', 'poe', 'roxas' ];

            function initialize() {
                $rootScope.pageClass = 'candidate-page';

                if (vm.candidates.indexOf($stateParams.name) > -1) {
                    $rootScope.title = 'Candidate: ' + ($stateParams.name.charAt(0).toUpperCase() + $stateParams.name.slice(1))  + ' - KandiData';
                } else {
                    $state.go('home');
                }
            }

            initialize();
        }
    ]);
