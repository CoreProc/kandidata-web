// App Config

angular
	.module('kandidata', ['ui.router']);

angular.module('kandidata')
	.run([
		'$rootScope',
		'$state',
		'$stateParams',
		function ($rootScope, $state, $stateParams) {
	        $rootScope.$state = $state;
	        $rootScope.$stateParams = $stateParams;

	        $rootScope.$on('$stateChangeStart', function (event, toState, toParams) {
	            $rootScope.title = toState.data.title;
	        });
    	}
    ]);
