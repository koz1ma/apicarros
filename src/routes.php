<?php
// Routes

$app->delete('/accessories/{id}/delete', function ($request, $response, $args) {
    $key = $this->get('settings')['jwt_key'];
    $token = $request->getHeader("Authorization");

    if(!verifyToken($key,$token)){
        return $response->withStatus(401)->write('Token inválido.');
    }

    $data = $request->getParsedBody();
    $id = (int)$args['id'];

    $result = $this->db->prepare('  DELETE FROM 
                                        acessorio
                                    WHERE 
                                        idacessorio = :id ');
    $result->bindParam(':id', $id, PDO::PARAM_INT);

    $success = $result->execute();

    if(!$success){
        return $response->withJson($result->errorInfo());
    }else{
        return $response->withJson("Acessorio excluido com sucesso.");
    }
});

//função para adicionar um acessorio

$app->post('/accessories/add', function ($request, $response) {
    $key = $this->get('settings')['jwt_key'];
    $token = $request->getHeader("Authorization");

    if(!verifyToken($key,$token)){
        return $response->withStatus(401)->write('Token inválido.');
    }

    $data = $request->getParsedBody();
    $nome = filter_var($data['nome'], FILTER_SANITIZE_STRING);
    $status = filter_var($data['status'], FILTER_SANITIZE_STRING);

    $result = $this->db->prepare('	INSERT INTO 
    									acessorio( nome, status)
	    							VALUES 
	    								( :nome, :status) ');
	$result->bindParam(':nome', $nome, PDO::PARAM_STR);
	$result->bindParam(':status', $status, PDO::PARAM_STR);
	$result->execute();

	$newId = $this->db->lastInsertId();

	return $response->withJson($newId);
});

//função para editar um acessorio

$app->post('/accessories/{id}/edit', function ($request, $response, $args) {

    $key = $this->get('settings')['jwt_key'];
    $token = $request->getHeader("Authorization");

    if(!verifyToken($key,$token)){
        return $response->withStatus(401)->write('Token inválido.');
    }

    $data = $request->getParsedBody();
    $id = (int)$args['id'];
    $nome = filter_var($data['nome'], FILTER_SANITIZE_STRING);
    $status = filter_var($data['status'], FILTER_SANITIZE_STRING);

    $result = $this->db->prepare('  UPDATE
                                        acessorio
                                    SET
                                        nome = :nome,
                                        status = :status
                                    WHERE 
                                        idmodelo = :id ');
    $result->bindParam(':id', $id, PDO::PARAM_INT);
    $result->bindParam(':nome', $nome, PDO::PARAM_STR);
    $result->bindParam(':status', $status, PDO::PARAM_STR);
    $success = $result->execute();

    if(!$success){
        return $response->withJson($result->errorInfo());
    }else{
        return $response->withJson("Acessorio editado com sucesso.");
    }
});

//função para receber os dados de um acessorio

$app->get('/accessories/{id}', function ($request, $response, $args) {

    $key = $this->get('settings')['jwt_key'];
    $token = $request->getHeader("Authorization");

    if(!verifyToken($key,$token)){
        return $response->withStatus(401)->write('Token inválido.');
    }

    $id = (int)$args['id'];

    $result = $this->db->prepare('  SELECT
                                        *
                                    FROM 
                                        acessorio
                                    WHERE
                                        idacessorio = :id ');
    $result->bindParam(':id', $id, PDO::PARAM_INT);
    $result->execute();

    $accessory = $result->fetchAll();

    return $response->withJson($accessory);
});

//função para receber os dados de todos os acessorios

$app->get('/accessories', function ($request, $response, $args) {

    $key = $this->get('settings')['jwt_key'];
    $token = $request->getHeader("Authorization");

    if(!verifyToken($key,$token)){
        return $response->withStatus(401)->write('Token inválido.');
    }

    $sql = "SELECT
                * 
            FROM 
                acessorio";

    $result = $this->db->query( $sql );
    $accessories = $result->fetchAll();

    return $response->withJson($accessories);
});

//função para excluir um modelo

$app->delete('/models/{id}/delete', function ($request, $response, $args) {

    $key = $this->get('settings')['jwt_key'];
    $token = $request->getHeader("Authorization");

    if(!verifyToken($key,$token)){
        return $response->withStatus(401)->write('Token inválido.');
    }

    $data = $request->getParsedBody();
    $id = (int)$args['id'];

    $result = $this->db->prepare('  DELETE FROM 
                                        modelo
                                    WHERE 
                                        idmodelo = :id ');
    $result->bindParam(':id', $id, PDO::PARAM_INT);

    $success = $result->execute();

    if(!$success){
        return $response->withJson($result->errorInfo());
    }else{
        return $response->withJson("Modelo excluido com sucesso.");
    }
});

//função para editar um modelo

$app->post('/models/{id}/edit', function ($request, $response, $args) {
    $key = $this->get('settings')['jwt_key'];
    $token = $request->getHeader("Authorization");

    if(!verifyToken($key,$token)){
        return $response->withStatus(401)->write('Token inválido.');
    }

    $data = $request->getParsedBody();
    $id = (int)$args['id'];
    $nome = filter_var($data['nome'], FILTER_SANITIZE_STRING);
    $aro = filter_var($data['aro'], FILTER_SANITIZE_NUMBER_INT);
    $ano = filter_var($data['ano'], FILTER_SANITIZE_NUMBER_INT);

    $result = $this->db->prepare('	UPDATE
    									modelo
    								SET
    									nome = :nome,
    									aro = :aro,
    									ano = :ano
	    							WHERE 
	    								idmodelo = :id ');
    $result->bindParam(':id', $id, PDO::PARAM_INT);
	$result->bindParam(':nome', $nome, PDO::PARAM_STR);
	$result->bindParam(':aro', $aro, PDO::PARAM_INT);
	$result->bindParam(':ano', $ano, PDO::PARAM_INT);
	$success = $result->execute();

	if(!$success){
		return $response->withJson($result->errorInfo());
	}else{
		return $response->withJson("Modelo editado com sucesso.");
	}
});

//função para remover o acessorio de um modelo

$app->delete('/models/{id}/accessories/delete', function ($request, $response, $args) {
    $key = $this->get('settings')['jwt_key'];
    $token = $request->getHeader("Authorization");

    if(!verifyToken($key,$token)){
        return $response->withStatus(401)->write('Token inválido.');
    }

    $data = $request->getParsedBody();
    $id = (int)$args['id'];
    $id_accessory = filter_var($data['id_acessorio'], FILTER_SANITIZE_NUMBER_INT);

    $result = $this->db->prepare('	DELETE FROM 
    									modelo_acessorio ma
	    							WHERE 
	    								ma.modelo_idmodelo = :id AND ma.acessorio_idacessorio = :id_acessorio ');
	$result->bindParam(':id', $id, PDO::PARAM_INT);
	$result->bindParam(':id_acessorio', $id_accessory, PDO::PARAM_INT);

	return $response->withJson($result->execute());
});

//função para adicionar um acessorio a um modelo

$app->post('/models/{id}/accessories/add', function ($request, $response, $args) {
    $key = $this->get('settings')['jwt_key'];
    $token = $request->getHeader("Authorization");

    if(!verifyToken($key,$token)){
        return $response->withStatus(401)->write('Token inválido.');
    }

    $data = $request->getParsedBody();
    $id = (int)$args['id'];
    $id_accessory = filter_var($data['id_acessorio'], FILTER_SANITIZE_NUMBER_INT);

    $result = $this->db->prepare('	INSERT INTO 
    									modelo_acessorio( modelo_idmodelo, acessorio_idacessorio)
	    							VALUES 
	    								( :id, :id_acessorio) ');
	$result->bindParam(':id', $id, PDO::PARAM_INT);
	$result->bindParam(':id_acessorio', $id_accessory, PDO::PARAM_INT);

	return $response->withJson($result->execute());
});

//função para adicionar um modelo

$app->post('/models/add', function ($request, $response) {
    $key = $this->get('settings')['jwt_key'];
    $token = $request->getHeader("Authorization");

    if(!verifyToken($key,$token)){
        return $response->withStatus(401)->write('Token inválido.');
    }

    $data = $request->getParsedBody();
    $nome = filter_var($data['nome'], FILTER_SANITIZE_STRING);
    $aro = filter_var($data['aro'], FILTER_SANITIZE_NUMBER_INT);
    $ano = filter_var($data['ano'], FILTER_SANITIZE_NUMBER_INT);

    $result = $this->db->prepare('	INSERT INTO 
    									modelo( nome, aro, ano)
	    							VALUES 
	    								( :nome, :aro, :ano) ');
	$result->bindParam(':nome', $nome, PDO::PARAM_STR);
	$result->bindParam(':aro', $aro, PDO::PARAM_INT);
	$result->bindParam(':ano', $ano, PDO::PARAM_INT);
	$result->execute();

	$newId = $this->db->lastInsertId();

	return $response->withJson($newId);
});

//função para visualizar os dados de um modelo

$app->get('/models/{id}', function ($request, $response, $args) {

    $key = $this->get('settings')['jwt_key'];
    $token = $request->getHeader("Authorization");

    if(!verifyToken($key,$token)){
        return $response->withStatus(401)->write('Token inválido.');
    }

    $id = (int)$args['id'];

    $result = $this->db->prepare('  SELECT
                                        *
                                    FROM 
                                        modelo
                                    WHERE
                                        idmodelo = :id ');
    $result->bindParam(':id', $id, PDO::PARAM_INT);
    $result->execute();

    $model = $result->fetchAll();

    return $response->withJson($model);
});

//função para visualizar os dados de todos os modelos


$app->get('/models', function ($request, $response, $args) {

    $key = $this->get('settings')['jwt_key'];
    $token = $request->getHeader("Authorization");

    if(!verifyToken($key,$token)){
        return $response->withStatus(401)->write('Token inválido.');
    }

    $sql = "SELECT
    			* 
    		FROM 
    			modelo";

    $result = $this->db->query( $sql );
	$models = $result->fetchAll();

    return $response->withJson($models);
});

//função para gerar um token JWT

$app->post('/getToken', function ($request, $response, $args) {
    $data = $request->getParsedBody();
    $username = filter_var($data['login'], FILTER_SANITIZE_STRING);
    $password = filter_var($data['senha'], FILTER_SANITIZE_STRING);
    $key = $this->get('settings')['jwt_key'];

    if(($username == "usuarioteste") && ($password == "123456")){
        $token = generateToken($key, $username);
    }else{
        return $response->withStatus(401)->write('Login e senha invalidos.');
    }   

    return $response->withJson($token);
});

//função para visualizar os acessorios de um modelo


$app->get('/models/{id}/accessories', function ($request, $response, $args) {

    $key = $this->get('settings')['jwt_key'];
    $token = $request->getHeader("Authorization");

    if(!verifyToken($key,$token)){
        return $response->withStatus(401)->write('Token inválido.');
    }

    $id = (int)$args['id'];

    $result = $this->db->prepare('	SELECT 
    									a.*
	    							FROM 
	    								acessorio a INNER JOIN modelo_acessorio ma ON a.idacessorio = ma.acessorio_idacessorio 
	    							WHERE
	    								ma.modelo_idmodelo = :id ');
	$result->bindParam(':id', $id, PDO::PARAM_INT);
	$result->execute();

	$acessories = $result->fetchAll();

    return $response->withJson($acessories);
});

//token para testes: "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VybmFtZSI6InVzdWFyaW90ZXN0ZSJ9.wryItrmg5w7uExyFRdifKwW3x7KCrD6fdx0bmE/ySjk="



