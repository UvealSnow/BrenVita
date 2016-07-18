// modeule declaration

	var app = angular.module('brenVita', ['ui.router', 'ngCookies', 'base64', 'angucomplete-alt', 'ngSanitize']);

// route configuration

	app.config(function ($stateProvider, $urlRouterProvider) {

		$urlRouterProvider.otherwise("/404");

		$stateProvider
			.state('home', { url: '/', templateUrl: 'templates/index.html', controller: 'mainCtrl', data: { requriesLogin: false } })
			.state('articles', { url: '/articulos/{id}', controller: 'artiCtrl', templateUrl: 'templates/articulos.html', data: { requriesLogin: false } })
			.state('recipes', { url: '/recetas/{id}', controller: 'reciCtrl', templateUrl: 'templates/recetas.html', data: { requriesLogin: false } })
			.state('workouts', { url: '/rutinas/{id}', controller: 'workCtrl', templateUrl: 'templates/rutinas.html', data: { requriesLogin: false } })
			.state('vlogs', { url: '/vlogs/{id}', controller: 'vlogCtrl', templateUrl: 'templates/vlogs.html', data: { requriesLogin: false } })
			.state('authors', { url: '/autores/{id}', controller: 'authCtrl', templateUrl: 'templates/authors.html', data: { requriesLogin: false } })
			.state('login', { url: '/admin-login', controller: 'loginCtrl', templateUrl: 'templates/login.html', data: { requriesLogin: false } })
			.state('logout', { url: '/logout', controller: 'logoutCtrl' })
			.state('new', { abstract: true, url: '/agregar', template: "<ui-view/>", data: { requriesLogin: true } })
			.state('new.article', { url: '/articulo', templateUrl: 'templates/new.article.html' })
			.state('new.recipe', { url: '/receta', templateUrl: 'templates/new.recipe.html' })
			.state('new.ingredient', { url: '/ingrediente', templateUrl: 'templates/new.ingredient.html' })
			.state('new.workout', { url: '/rutina', templateUrl: 'templates/new.workout.html' })
			.state('new.exercise', { url: '/ejercicio', templateUrl: 'templates/new.exercise.html' })
			.state('new.vlog', { url: '/vlog', templateUrl: 'templates/new.vlog.html' })
			.state('edit', { abstract: true, url: '/editar', template: "<ui-view/>", data: { requriesLogin: true } })
			.state('edit.article', { url: '/articulo/{id}', templateUrl: 'templates/edit.article.html' })
			.state('edit.recipe', { url: '/receta/{id}', templateUrl: 'templates/edit.recipe.html' })
			.state('edit.workout', { url: '/rutina/{id}', templateUrl: 'templates/edit.workout.html' })
			.state('edit.vlog', { url: '/vlog/{id}', templateUrl: 'templates/edit.vlog.html' })
			.state('delete', { abstract: true, url: '/eliminar', template: "<ui-view/>", data: { requriesLogin: true } })
			.state('delete.article', { url: '/articulo/{id}', controller: 'deleteArtCtrl' })
			.state('delete.recipe', { url: '/receta/{id}', controller: 'deleteRecCtrl' })
			.state('delete.workout', { url: '/rutina/{id}', controller: 'deleteWrkCtrl' })
			.state('delete.vlog', { url: '/vlog/{id}', controller: 'deleteVlgCtrl' })
			.state('404', { url: '/404', templateUrl: 'templates/404.html', data: { requriesLogin: false } });
	});

// index controller
	
	app.controller('mainCtrl', ['$scope', '$http', '$cookies', function ($scope, $http, $cookies) {
		console.log('index ctrl in');
	}]);

// articles controllers 

	app.controller('artiCtrl', ['$stateParams', '$scope', '$http', '$cookies', '$state', function ($stateParams, $scope, $http, $cookies, $state) {
		$scope.token = $cookies.get('token');
		var url = 'http://brenvita.dev/api/public/articulos';
		if ($stateParams.id != '') url += '/'+$stateParams.id;
		$http.get(url).then(function (res) {
			$scope.data = res.data;
		}, function (res) {
			console.log('request failed: '+ res.status);
		});

		$scope.alert = function (did) {
			confirm('Esta acción no puede deshacerse, seguro que quieres borrarlo?');
			$state.go('delete.article', {id: did})
		}
	}]);

	app.controller('deleteArtCtrl', ['$stateParams', '$scope', '$http', '$state', function ($stateParams, $scope, $http, $state) {
		console.log('delete art: '+$stateParams.id);
		var url = 'api/public/articulos/delete/'+$stateParams.id;
		$http.delete(url).then(function (res) {
			$state.go('articles');
		}, function (res) {
			console.log('request failed: '+ res.status);
		});
	}]);

// recipes controllers 

	app.controller('reciCtrl', ['$stateParams', '$scope', '$http', '$cookies', '$state', function ($stateParams, $scope, $http, $cookies, $state) {
		$scope.token = $cookies.get('token');
		var url = 'http://brenvita.dev/api/public/recetas';
		if ($stateParams.id != '') url += '/'+$stateParams.id;
		$http.get(url).then(function (res) {
			$scope.data = res.data;
		}, function (res) {
			console.log('request failed: '+ res.status);
		});

		$scope.alert = function (did) {
			confirm('Esta acción no puede deshacerse, seguro que quieres borrarlo?');
			$state.go('delete.article', {id: did})
		}
	}]);

	app.controller('deleteRecCtrl', ['$stateParams', '$scope', '$http', '$state', function ($stateParams, $scope, $http, $state) {
		console.log('delete art: '+$stateParams.id);
		var url = 'api/public/recetas/delete/'+$stateParams.id;
		$http.delete(url).then(function (res) {
			$state.go('recipes');
		}, function (res) {
			console.log('request failed: '+ res.status);
		});
	}]);

// workouts controllers 

	app.controller('workCtrl', ['$stateParams', '$scope', '$http', '$cookies', '$state', function ($stateParams, $scope, $http, $cookies, $state) {
		$scope.token = $cookies.get('token');
		var url = 'http://brenvita.dev/api/public/rutinas';
		if ($stateParams.id != '') url += '/'+$stateParams.id;
		$http.get(url).then(function (res) {
			$scope.data = res.data;
		}, function (res) {
			console.log('request failed: '+ res.status);
		});

		$scope.alert = function (did) {
			confirm('Esta acción no puede deshacerse, seguro que quieres borrarlo?');
			$state.go('delete.article', {id: did})
		}
	}]);

	app.controller('deleteWrkCtrl', ['$stateParams', '$scope', '$http', '$state', function ($stateParams, $scope, $http, $state) {
		console.log('delete art: '+$stateParams.id);
		var url = 'api/public/rutinas/delete/'+$stateParams.id;
		$http.delete(url).then(function (res) {
			$state.go('workouts');
		}, function (res) {
			console.log('request failed: '+ res.status);
		});
	}]);

// vlogs controllers 

	app.controller('vlogCtrl', ['$stateParams', '$scope', '$http', '$cookies', '$state', function ($stateParams, $scope, $http, $cookies, $state) {
		$scope.token = $cookies.get('token');
		var url = 'http://brenvita.dev/api/public/vlogs';
		if ($stateParams.id != '') url += '/'+$stateParams.id;
		$http.get(url).then(function (res) {
			$scope.data = res.data;
		}, function (res) {
			console.log('request failed: '+ res.status);
		});

		$scope.alert = function (did) {
			confirm('Esta acción no puede deshacerse, seguro que quieres borrarlo?');
			$state.go('delete.article', {id: did})
		}
	}]);

	app.controller('deleteVlgCtrl', ['$stateParams', '$scope', '$http', '$state', function ($stateParams, $scope, $http, $state) {
		console.log('delete art: '+$stateParams.id);
		var url = 'api/public/vlogs/delete/'+$stateParams.id;
		$http.delete(url).then(function (res) {
			$state.go('vlogs');
		}, function (res) {
			console.log('request failed: '+ res.status);
		});
	}]);

// author controllers 

	app.controller('authCtrl', ['$stateParams', '$scope', '$http', '$cookies', function ($stateParams, $scope, $http, $cookies) {
		$scope.token = $cookies.get('token');
		var url = 'http://brenvita.dev/api/public/vlogs';
		if ($stateParams.id != '') url += '/'+$stateParams.id;
		$http.get(url).then(function (res) {
			$scope.data = res.data;
		}, function (res) {
			console.log('request failed: '+ res.status);
		});
	}]);

// forms controllers 

	app.controller('loginCtrl', ['$location', '$scope', '$http', '$cookies', '$window', function ($location, $scope, $http, $cookies, $window) {
		var url = 'http://brenvita.dev/api/public/login';

		$scope.post = function () {
			var info = {user: $scope.user, pass: $scope.pass};
			$http({
				method: 'POST',
				url: url, 
				data: info
			}).then (function (res) {
				$cookies.put('token', res.data);
				$window.location.href = '#/';
			}, function (res) {
				$cookies.put('error', 'badLogin');
				$location.url('/login');
			});
		};
		
	}]);

	app.controller('logoutCtrl', ['$window', '$cookies', function ($window, $cookies) {
		// http api/public/logout (kills active session in db)
		$cookies.remove('token');
		$window.location.href = '#/';
	}]);

	app.controller('formCtrl', ['$scope', '$http', '$cookies', '$base64', function ($scope, $http, $cookies, $base64) {
		$scope.token = $cookies.get('token');
		$scope.token = $scope.token.split('.');
		$scope.decoded = JSON.parse(decodeURIComponent(escape($base64.decode($scope.token[1]))));
		// console.log($scope.decoded);
	}]);

	app.controller('addFields', ['$scope', function ($scope) {
		$scope.ingredients = [{}];

		$scope.addField = function () {
			$scope.ingredients.push({});
		};
	}]);

	app.controller('addSteps', ['$scope', function ($scope) {
		$scope.steps = [{}];

		$scope.addStep = function () {
			$scope.steps.push({});
		};
	}]);

	app.controller('addSets', ['$scope', function ($scope) {
		$scope.sets = [{}];

		$scope.addSet = function () {
			$scope.sets.push({});
		};
	}]);

	app.controller('addExer', ['$scope', function ($scope) {
		$scope.exer = [{}];

		$scope.addExer = function () {
			$scope.exer.push({});
		};
	}]);

// navbar controller
	
	app.controller('navCtrl', ['$scope', '$http', '$cookies', function ($scope, $http, $cookies) {
		$scope.token = $cookies.get('token');
		$scope.logged = !angular.isUndefined($cookies.get('user'));
		// console.log('navCtrl in, logged = '+$scope.token);
	}]);

// upload controller
	
	app.controller('upldCtrl', ['$scope', 'Upload', '$timeout', function ($scope, Upload, $timeout) {
		$scope.uploadPic = function(file) {
		    file.upload = Upload.upload({
		      	url: 'http://brenvita.dev/api/public/articulos',
		      	data: { username: $scope.username, file: file },
		    });

		    file.upload.then(function (response) {
		      	$timeout(function () {
		        	file.result = response.data;
		      	});
		    }, function (response) {
		      	if (response.status > 0)
		        	$scope.errorMsg = response.status + ': ' + response.data;
		    }, function (evt) {
		      	// Math.min is to fix IE which reports 200% sometimes
		      	file.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
		    });
		}
	}]);

// services
	
	app.factory('validateToken', ['$scope', '$http', '$cookies', function($scope, $http, $cookies) {
		if ($cookies.get('token')) { $scope.token = $cookies.get('token'); console.log('got it'); }
		else { $scope.token = false; }
		return  {
			validate : function () {
				if ($scope.token) {
					// to do: decode token
					// to do: $http request to validate token
						// if !$scope.token => location /login
						// elseif $scope.token.exp <= time() => location /login
						// else return http(200)
						console.log('entered factory!');
				}		
			}
		};
	}]);

	app.run(function($rootScope) {
	  	$rootScope.$on("$stateChangeError", console.log.bind(console));
	});
