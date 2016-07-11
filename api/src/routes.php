<?php
	// GET Routes

		$app->get('/recetas[/{id:[0-9]+}]', function ($req, $res, $args) { # done

			if (isset($args['id'])) {
				$i = 0;
				$data = array();
				$id = $args['id'];
				$sql = "SELECT u.id as 'auth_id', u.name as 'auth_name', r.id as 'recipe_id', r.name as 'recipe_name', r.video as 'recipe_video', r.img as 'recipe_img', r.img_desc as 'recipe_img_desc', i.id as 'ing_id', i.name as 'ing_name', i.unidad, rec_ing.cantidad, i.cals, i.img as 'ing_img' FROM recetas as r JOIN rec_ing ON rec_ing.rec_id = r.id JOIN ingredientes as i ON i.id = rec_ing.ing_id JOIN users as u ON r.auth_id = u.id WHERE r.id = '$id'";
				$pdo = $this->db->prepare($sql);
				$pdo->execute();
				$raw = $pdo->fetchAll(PDO::FETCH_ASSOC);
				foreach ($raw as $row) {
					if ($i == 0) {
						$data['id'] = $row['recipe_id']; 	 			# recipe id
						$data['name'] = $row['recipe_name']; 			# recipe name
						$data['img'] = $row['recipe_img']; 				# recipe img
						$data['img_desc'] = $row['recipe_img_desc']; 	# recipe img description
						$data['video'] = $row['recipe_video']; 			# recipe name
						$data['auth_id'] = $row['auth_id'];				# recipe's author id
						$data['auth_name'] = $row['auth_name'];			# recipe's author name
					}
					$data['ingredients'][$i]['id'] = $row['ing_id']; 		# recipe's ingredient id
					$data['ingredients'][$i]['name'] = $row['ing_name'];	# recipe's ingredient name
					$data['ingredients'][$i]['unit'] = $row['unidad'];		# recipe's ingredient unit
					$data['ingredients'][$i]['qnt'] = $row['cantidad'];		# recipe's ingredient qnt
					$data['ingredients'][$i]['cals'] = $row['cals'];		# recipe's ingredient cals
					$data['ingredients'][$i]['ing_img'] = $row['ing_img'];	# recipe's ingredient img
					$i++;
				}
				$i = 0;
				$sql = "SELECT pasos.text as 'text' FROM pasos WHERE rec_id = '$id' ORDER BY pasos.order ASC";
				$pdo = $this->db->prepare($sql);
				$pdo->execute();
				$raw = $pdo->fetchAll(PDO::FETCH_ASSOC);

				foreach ($raw as $row) {
					$data['pasos'][$i] = $row['text'];		# recipe's steps
					$i++;
				}

				$this->logger->info("Brenvita '/recetas[/{$id}]' route");
				return $res->withJson($data, 200);
			}
			else {
				$sql = "SELECT * FROM recetas";
				$pdo = $this->db->prepare($sql);
				$pdo->execute();
				$data = $pdo->fetchAll(PDO::FETCH_ASSOC);
				return $res->withJson($data, 200);
				$this->logger->info("Brenvita '/articulos' route");
			}
		});

		$app->get('/rutinas[/{id:[0-9]+}]', function ($req, $res, $args) { # done
			if (isset($args['id'])) {
				$data = array();
				$id = $args['id'];

				$i = 0;
				$j = 0;
				$set = 0;

				$sql = "SELECT r.id as 'rut_id', r.auth_id as 'rut_auid', u.name as 'rut_auth', r.name as 'rut_name', r.desc as 'rut_desc', r.created as 'rut_crea', r.img as 'rut_img', r.img_desc as 'rut_img_desc', s.id as 'set_id', s.name as 'set_name', r_s.reps as 'set_reps', e.id as 'exe_id', e.name as 'exe_name', e.desc as 'exe_desc', e.calorias as 'exe_cals', s_e.reps as 'exe_reps' FROM rutinas as r JOIN users as u ON u.id = r.auth_id JOIN rut_set as r_s ON r.id = r_s.rut_id JOIN sets as s ON r_s.set_id = s.id JOIN set_eje as s_e ON s.id = s_e.set_id JOIN ejercicios as e ON s_e.eje_id = e.id WHERE r.id = '1'";
				$pdo = $this->db->prepare($sql);
				$pdo->execute();
				$raw = $pdo->fetchAll(PDO::FETCH_ASSOC);

				foreach ($raw as $row) {
					if ($i == 0) {
						$data['id'] = $row['rut_id'];				# rutina id
						$data['auth_id'] = $row['rut_auid'];		# rutina autor id
						$data['auth'] = $row['rut_auth'];			# rutina autor name
						$data['name'] = $row['rut_name'];			# rutina name
						$data['desc'] = $row['rut_desc'];			# rutina descripcion
						$data['img'] = $row['rut_img'];				# rutina img
						$data['img_desc'] = $row['rut_img_desc'];	# rutina img desc
						$data['created'] = $row['rut_crea'];		# rutina created
						$i++;
					}
					if ($set == 0 || $set != $row['set_id']) {
						$j = 0;
						$set = $row['set_id'];
						$data['sets'][$set]['id'] = $row['set_id'];			# set id
						$data['sets'][$set]['name'] = $row['set_name'];		# set name
						$data['sets'][$set]['reps'] = $row['set_reps'];		# set reps
					} 
					$data['sets'][$set]['exrcs'][$j]['id'] = $row['exe_id']; 		# exercise id
					$data['sets'][$set]['exrcs'][$j]['name'] = $row['exe_name'];	# exercise name
					$data['sets'][$set]['exrcs'][$j]['desc'] = $row['exe_desc'];	# exercise desc
					$data['sets'][$set]['exrcs'][$j]['cals'] = $row['exe_cals'];	# exercise calorías 
					$data['sets'][$set]['exrcs'][$j]['reps'] = $row['exe_reps'];	# exercise reps
					$j++;
				}

				return $res->withJson($data, 200);
			}
			else {
				$sql = "SELECT rutinas.*, users.name as 'rut_auth' FROM rutinas JOIN users ON users.id = rutinas.auth_id";
				$pdo = $this->db->prepare($sql);
				$pdo->execute();
				$data = $pdo->fetchAll(PDO::FETCH_ASSOC);
				return $res->withJson($data, 200);
			}
		});
 
		$app->get('/articulos[/{id:[0-9]+}]', function ($req, $res, $args) { # done
			$this->logger->info("Brenvita '/articulos[/{id}]' route");

			if (isset($args['id'])) {
				$id = $args['id'];
				$sql = "SELECT a.*, u.name as 'auth' FROM articulos as a JOIN users as u ON a.auth_id = u.id WHERE a.id = '$id'";
				$this->logger->info("Brenvita '/articulos[/{$id}]' route");
			}
			else {
				$sql = "SELECT a.*, u.name as 'auth' FROM articulos as a JOIN users as u ON a.auth_id = u.id";
				$this->logger->info("Brenvita '/articulos' route");
			}

			$pdo = $this->db->prepare($sql);
			$pdo->execute();
			$data = $pdo->fetchAll(PDO::FETCH_ASSOC);

			return $res->withJson($data, 200);
		});

		$app->get('/vlogs[/{id:[0-9]+}]', function ($req, $res, $args) { # done

			$sql = "SELECT v.*, u.name as 'auth' FROM vlogs as v JOIN users as u on u.id = v.auth_id ";

			if (isset($args['id'])) {
				$id = $args['id'];
				$sql = $sql." WHERE id = '$id'";
				$this->logger->info("Brenvita '/vlogs[/{$id}]' route");
			}
			else $this->logger->info("Brenvita '/vlogs' route");

			$pdo = $this->db->prepare($sql);
			$pdo->execute();
			$data = $pdo->fetchAll(PDO::FETCH_ASSOC);

			return $res->withJson($data, 200);
		});

		$app->get('/logout', function ($req, $res, $args) { # done
			if (isset($_SESSION['user'])) {
				unset($_SESSION['user']);
				return $res->withStatus(200)->withHeader('Location', 'http://brenvita.dev/');
			}
			else return $res->withStatus(400)->withHeader('Location', 'http://brenvita.dev/');
		});

	// POST Routes 

		$app->post('/login', function ($req, $res, $args) { # done

			$postdata = file_get_contents("php://input");
			$input = json_decode($postdata);

			if (isset($input->user) && isset($input->pass)) {
				$user = $input->user;
				$pass = $input->pass;
			}
			else return $res->withStatus(400);


			$sql = "SELECT id, name, user, pass FROM users WHERE user = '$user'";
			$pdo = $this->db->prepare($sql);
			$pdo->execute();
			$data = $pdo->fetch(PDO::FETCH_ASSOC);

			if (password_verify($pass, $data['pass'])) {
				$data['pass'] = true;

				$sql = "UPDATE users SET last_login = current_timestamp";
				$pdo = $this->db->prepare($sql);
				$pdo->execute();
				$this->logger->info("login: ".$data['name']." at: ".time());

				$header = [
					'alg' => 'HS256',
					'typ' => 'JWT',
				];

				$payload = [
					'iss' => 'http://brenvita/api/public/login',
					'exp' => time() + (60 * 60), # time + 60 mins;
					'iat' => time(),
					'jti' => hash('sha256', $pass.time()),
					'uid' => $data['id'],
				];

				$header = base64_encode(json_encode($header));
				$payload = base64_encode(json_encode($payload));
				$signature = hash('sha256', $header.'.'.$payload);
				$token = $header.'.'.$payload.'.'.$signature;

				# var_dump($header, $payload, $signature, $token);
				
				return $res->withStatus(200)->write($token);
			}
			
			else {
				# var_dump($_POST);
				return $res->withStatus(401);
			} 
		});

		$app->post('/recetas/new', function ($req, $res, $args) {
			$this->logger->info("Brenvita POST - '/recetas' route");
		});

		$app->post('/rutinas/new', function ($req, $res, $args) {
			$this->logger->info("Brenvita POST - '/rutinas' route");
		});

		$app->post('/articulos-new', function ($req, $res, $args) { # done

			$auth = $_POST['uid'];
			$name = $_POST['art_name'];
			$text = $_POST['editor'];
			$video = $_POST['art_vide'];

			$file = $_FILES['img'];
			$fnam = $file['name'];
			$ides = $_POST['img_desc'];

			# var_dump($_POST, $file);

			if ($video != '') { # if video is not null
				$sql = "INSERT INTO articulos 
				(auth_id, vid_switch, video, name, text, created) 
				VALUES ('$auth', 1, '$video', '$name', :html, current_timestamp)"; 
			}
			else { # if video is null we use pic
				# var_dump($file);
				$sql = "INSERT INTO articulos (id, auth_id, name, text, created, img, img_desc) VALUES (null, '$auth', '$name', '$text', current_timestamp, '$fnam', '$ides')";
				$targetDir = '../../img/articles/';
				$targetFile = $targetDir.$file['name'];
				$fileType =  pathinfo($targetFile,PATHINFO_EXTENSION);
				
				$upload = true;

				$accepted = array("jpg", "jpeg", "png", "gif");
				$check = getimagesize($_FILES["img"]["tmp_name"]);

				if ($check == false) { $upload = false; echo "verification failed: check"; }
				elseif (file_exists($targetFile)) { $upload = false; echo "verification failed: file exists"; }
				elseif (!in_array($fileType, $accepted)) { $upload = false; echo "verification failed: filetype not good"; }

				# var_dump($upload);

				if (move_uploaded_file($_FILES["img"]["tmp_name"], $targetFile)) $this->logger->info("Brenvita new article: ".$sql." at: ".time());
				else { echo 'There was a mistake uploading the image!'; }	
			} 

			$pdo = $this->db->prepare($sql);
			$pdo->bindValue(':html', $text, PDO::PARAM_STR);
			# echo $sql;
			$pdo->execute();
			
			return $res->withStatus(200)->withHeader('Location', 'http://brenvita.dev/#/articulos/');
			# else $res->withStatus(400)->withHeader('Location', '#/agregar/articulo');

		});

		$app->post('/vlogs/new', function ($req, $res, $args) {
			$this->logger->info("Brenvita POST - '/vlogs' route");
		});

	// PUT Routes

	// DELETE Routes

		$app->delete('/articulos/delete/{id}', function ($req, $res, $args) {
			echo "delete articulo(id)";
		});

		$app->delete('/vlogs/delete/{id}', function ($req, $res, $args) {
			echo "delete vlog(id)";
		});

		$app->delete('/recetas/delete/{id}', function ($req, $res, $args) {
			echo "delete receta(id) & rec_ing references";
		});

		$app->delete('/rutinas/delete/{id}', function ($req, $res, $args) {
			echo "delete rutina(id) & rec_ing references";
		});

?>