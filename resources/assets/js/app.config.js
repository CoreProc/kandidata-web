// App Config

angular.module('kandidata', [
        'ngAnimate',
        'angularMoment',
        'ui.router',
        'oc.lazyLoad'
    ]);

angular.module('kandidata')
    .filter('encodeURIComponent', function () {
        return window.encodeURIComponent;
    });

angular.module('kandidata')
    .run([
        '$rootScope',
        '$state',
        '$stateParams',
        function ($rootScope, $state, $stateParams) {
            $rootScope.$state = $state;
            $rootScope.$stateParams = $stateParams;

            $rootScope.$on('$stateChangeStart', function () {
                document.body.scrollTop = document.documentElement.scrollTop = 0;
            });
        }
    ]);
