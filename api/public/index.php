<?php

	if (PHP_SAPI == 'cli-server') {
	    // To help the built-in PHP dev server, check if the request was actually for
	    // something which should probably be served as a static file
	    $url  = parse_url($_SERVER['REQUEST_URI']);
	    $file = __DIR__ . $url['path'];
	    if (is_file($file)) {
	        return false;
	    }
	}

	require __DIR__ . '/../vendor/autoload.php';

	session_start();

	// Instantiate the app
	$settings = require __DIR__ . '/../src/settings.php';

	$dsn = 'mysql:host='.$settings['settings']['db']['host'].';dbname='.$settings['settings']['db']['dbname'].';charset=utf8';
	$usr = $settings['settings']['db']['user'];
	$pwd = $settings['settings']['db']['pass'];

	$pdo = new \Slim\PDO\Database($dsn, $usr, $pwd);

	/*
	$sql = $pdo->select()->from('users');
	$res = $sql->execute();
	$data = $res->fetch();
	var_dump($data);
	*/


	$app = new \Slim\App($settings);

	// Set up dependencies
	require __DIR__ . '/../src/dependencies.php';

	// Register middleware
	require __DIR__ . '/../src/middleware.php';

	// Register routes
	require __DIR__ . '/../src/routes.php';

	// Run app
	$app->run();

?>