// Router
angular.module('kandidata')
    .config(function ($stateProvider, $urlRouterProvider) {
        $stateProvider
            .state('home', {
                url: '/',
                templateUrl: 'tpl/home.html',
                controller: 'KandiDataHomeCtrl as homeCtrl',
                data: {
                    title: 'KandiData | A data-driven Web Application for Twitter metrics for the Philippines Election 2016 presidential candidates'
                }
            })
            .state('candidates', {
                url: '/candidate/:name/',
                templateUrl: 'tpl/candidate.html',
                params: {
                    name: null
                },
                data: {
                    title: 'Candidate - KandiData'
                }
            });

        $urlRouterProvider.otherwise("/");
    });

