// Router
angular.module('kandidata')
    .config([
        '$stateProvider',
        '$urlRouterProvider',
        function ($stateProvider, $urlRouterProvider) {
            $stateProvider
                .state('app', {
                    abstract: true,
                    templateUrl: 'tpl/sections/main.html',
                    controller: 'AppController as appCtrl',
                    resolve: loadJs([
                        'assets/js/controllers/app.js',
                        'assets/js/services/session.js',
                        'assets/js/factories/api.js'
                    ])
                })
                .state('home', {
                    parent: 'app',
                    url: '/',
                    templateUrl: 'tpl/home.html',
                    controller: 'HomeController as homeCtrl',
                    resolve: loadJs([
                        'assets/js/controllers/home.js',
                        'assets/js/services/session.js',
                        'assets/js/factories/api.js'
                    ])
                })
                .state('candidates', {
                    parent: 'app',
                    url: '/candidate/:name/',
                    templateUrl: 'tpl/candidate.html',
                    params: {
                        id: null,
                        name: null
                    },
                    controller: 'CandidateController as candidateCtrl',
                    resolve: loadJs([
                        'assets/js/controllers/candidate.js',
                        'assets/js/services/session.js',
                        'assets/js/factories/api.js',
                        'assets/lib/amcharts/dist/amcharts/pie.js',
                        'assets/lib/amcharts/dist/amcharts/serial.js',
                        'assets/lib/amcharts/dist/amcharts/themes/light.js'
                    ])
                });

            $urlRouterProvider.otherwise("/");

            function loadJs(srcs, callback) {
                return {
                    deps: ['$ocLazyLoad', '$q',
                        function ($ocLazyLoad, $q) {
                            var deferred = $q.defer();
                            var promise = false;
                            srcs = angular.isArray(srcs) ? srcs : srcs.split(/\s+/);
                            if (!promise) {
                                promise = deferred.promise;
                            }
                            angular.forEach(srcs, function (src) {
                                promise = promise.then(function () {
                                    return $ocLazyLoad.load(src);
                                });
                            });
                            deferred.resolve();
                            return callback ? promise.then(function () {
                                return callback();
                            }) : promise;
                        }]
                }
            }

        }
    ]);

