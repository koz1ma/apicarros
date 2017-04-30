<?php

//função que gera um token

function generateToken($key,$username){
    #JWT Json Web Token


    $header = [
        'typ' => 'JWT',
        'alg' => 'HS256'
    ];

    # Codifica o header para json (base 64)
    $header = json_encode($header);
    $header = base64_encode($header);


    # Tudo o que coloca aqui será lido pela aplicação que o recebe.
    $payload = [
        'username' => $username,
    ];

    $payload = json_encode($payload);
    $payload = base64_encode($payload);

    # envia o tipo de codificação, o token, a chave e true = retorno binário
    $signature = hash_hmac('sha256', "$header.$payload", $key, true);

    $signature = base64_encode($signature);

    $token = "$header.$payload.$signature";

    # Copiar a saída: $token e colar no site
    # https://jwt.io/
    # validar com a string contida em $key
    return $token;
}

//função que verifica um token

function verifyToken($key,$header){
    // remove o Bearer do token 
    $token = explode(" ", $header[0]);
    $tokenParts = explode(".", $token[1]);
    $token = $token[1];

    //decodifica o payload para pegar os dados do usuario
    $payload = json_decode(base64_decode($tokenParts[1]));
    $username = $payload->username;

    //gera um token com a informação inserida e compara
    if($token == generateToken($key,$username)){
        return true;
    }else{
        return false;
    }
}