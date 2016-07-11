<!DOCTYPE html>
	<html>
	<head>
		<title>BrenVita</title>
		<link rel="icon" href="favicon.ico">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<link rel="stylesheet" type="text/css" href="css/main.css" media="screen, handheld"/>
		<script type="text/javascript" src="js/vendor/jquery.min.js"></script>
		<script type="text/javascript" src="js/vendor/ckeditor.js"></script>
		<script type="text/javascript" src="js/vendor/imagesloaded.min.js"></script>
		<script type="text/javascript" src="js/vendor/imagefill.js"></script>
		<script type="text/javascript" src="js/vendor/angular.min.js"></script>
		<script type="text/javascript" src="js/vendor/angular-ui-router.min.js"></script>
		<script type="text/javascript" src="js/vendor/angular-cookies.min.js"></script>
		<script type="text/javascript" src="js/app.js"></script>
		<link rel="stylesheet" type="text/css" href="css/main.css" media="screen, handheld"/>
	</head>
	<div class="nav" ng-controller="navCtrl">
		<a ui-sref="home">index</a>
		<a ui-sref="articles">artículos</a>
		<a ui-sref="recipes">recetas</a>
		<a ui-sref="workouts">rutinas</a>
		<a ui-sref="vlogs">vlogs</a>
		<a ui-sref="logout" ng-if="token">logout</a>
	</div>
	<body ng-app="brenVita">
		<div ui-view></div>
	</body>
</html>