// App Config

angular
	.module('kandidata', [
		'ngAnimate',
		'angularMoment',
		'ui.router',
		'oc.lazyLoad'
	]);

angular.module('kandidata')
	.run([
		'$rootScope',
		'$state',
		'$stateParams',
		function ($rootScope, $state, $stateParams) {
	        $rootScope.$state = $state;
	        $rootScope.$stateParams = $stateParams;
    	}
    ]);
