<?php
	// GET Routes

		$app->get('/', function ($req, $res, $args) {
			$this->logger->info("Brenvita '/' route");
			return $this->renderer->render($res, 'index.phtml', $args);
		});

		$app->get('/login', function ($req, $res, $args) {
			$this->logger->info("Brenvita '/login' route");
			return $this->renderer->render($res, 'login.phtml', $args);
		});

		$app->get('/recetas[/{id:[0-9]+}]', function ($req, $res, $args) {
		    $this->logger->info("Brenvita '/recetas[/{id}]' route");
		    return $this->renderer->render($res, 'recetas.phtml', $args);
		});

		$app->get('/rutinas[/{id:[0-9]+}]', function ($req, $res, $args) {
			$this->logger->info("Brenvita '/rutinas[/{id}]' route");
			return $this->renderer->render($res, 'rutinas.phtml', $args);
		});

		$app->get('/articulos[/{id:[0-9]+}]', function ($req, $res, $args) {
			$this->logger->info("Brenvita '/articulos[/{id}]' route");
			return $this->renderer->render($res, 'articulos.phtml', $args);
		});

		$app->get('/vlogs[/{id:[0-9]+}]', function ($req, $res, $args) {
			$this->logger->info("Brenvita '/vlogs[/{id}]' route");
			return $this->renderer->render($res, 'vlogs.phtml', $args);
		});

		$app->get('/hash/{hash}', function ($req, $res, $args) {
			$pass = password_hash($req->getAttribute('hash'), PASSWORD_BCRYPT);
			$res->getBody()->write("$pass");
			return $res;
		});

		$app->get('/logout', function ($req, $res, $args) {
			if (isset($_SESSION['user'])) {
				unset($_SESSION['user']);
				return $res->withStatus(200)->withHeader('Location', '/');
			}
			else return $res->withStatus(400)->withHeader('Location', '/');
		});

	// GET form Routes

		$app->get('/recetas/add', function ($req, $res, $args) {
		    $this->logger->info("Brenvita '/recetas/add' route");
		    return $this->renderer->render($res, 'recetas-add.phtml', $args);
		});

		$app->get('/rutinas/add', function ($req, $res, $args) {
		    $this->logger->info("Brenvita '/rutinas/add' route");
		    return $this->renderer->render($res, 'rutinas-add.phtml', $args);
		});

		$app->get('/articulos/add', function ($req, $res, $args) {
		    $this->logger->info("Brenvita '/articulos/add' route");
		    return $this->renderer->render($res, 'articulos-add.phtml', $args);
		});

		$app->get('/vlogs/add', function ($req, $res, $args) {
		    $this->logger->info("Brenvita '/vlogs/add' route");
		    return $this->renderer->render($res, 'vlogs-add.phtml', $args);
		});

	// POST Routes 

		$app->post('/login/auth', function ($req, $res, $args) {
			# var_dump($_POST);
			$user = $_POST['user'];
			$pass = $_POST['pass'];

			$sql = "SELECT * FROM users WHERE user = '$user'";
			$pdo = $this->db->prepare($sql);
			$pdo->execute();
			$data = $pdo->fetch(PDO::FETCH_ASSOC);

			if (password_verify($pass, $data['pass'])) {
				# $json = $res->withJson($data, 200);
				$data['pass'] = true;
				$_SESSION['user'] = $data;
				$sql = "UPDATE users SET last_login = current_timestamp";
				$pdo = $this->db->prepare($sql);
				$pdo->execute();
				# return $json;
				$this->logger->info("login: ".$data['name']." at: ".time());
				return $res->withStatus(200)->withHeader('Location', '/');
			}
			else {
				return $res->withStatus(401)->withHeader('Location', '/login');
			} 
		});

		$app->post('/recetas/new', function ($req, $res, $args) {
			$this->logger->info("Brenvita POST - '/recetas' route");
		});

		$app->post('/rutinas/new', function ($req, $res, $args) {
			$this->logger->info("Brenvita POST - '/rutinas' route");
		});

		$app->post('/articulos/new', function ($req, $res, $args) {
			$auth = $_SESSION['user']['id'];
			$sql = "INSERT INTO articulos VALUES (null, $auth, )";
			$pdo = $this->db->prepare($sql);
			# $pdo->execute();
			$this->logger->info("Brenvita new article: ".$sql." at: ".time());
		});

		$app->post('/vlogs/new', function ($req, $res, $args) {
			$this->logger->info("Brenvita POST - '/vlogs' route");
		});

	// PUT Routes


	// DELETE Routes

?>