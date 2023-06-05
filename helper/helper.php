<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function cleanData($con, $data){

     $sql_clean = mysqli_real_escape_string($con, $data);
     $clean_html = htmlspecialchars(strip_tags($sql_clean));
     
     return $clean_html;
}


//Check if login credential provided by user is valid
function isValidLoginCredentials($username='', $password=''){
    $isLoggedIn = true;
    return $isLoggedIn;
}

function validateToken($conn){

    //Check if client provide authorization
    if(!isset($_SERVER['HTTP_AUTHORIZATION'])){
        return ["status" => "Failed authorization", "message"=>"You need authorization for access."];
        exit;
    }

    //Check if token is found
    if (! preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'], $matches)) {
        header('HTTP/1.0 400 Bad Request');
        return ["status" => "Failed authorization", "message"=>"Token not found in request."];
        exit;
    }

    $jwt = $matches[1];
    if (!$jwt) {
        // No token was able to be extracted from the authorization header
        header('HTTP/1.0 400 Bad Request');
        return ["status" => "Failed authorization", "message"=>"Token not found in request."];
        exit;
    }

    $token = new Token($conn);
    $response = $token->getAClientByToken($jwt);
    
    try{
        $secretKey  = $response['secrete'];
        $token = JWT::decode($jwt, new Key($secretKey, 'HS512'));
        $now = new DateTimeImmutable();
        $serverName = "localhost";
        
        //Confirm validity of token
        if ($token->iss !== $serverName ||
            $token->nbf > $now->getTimestamp() ||
            $token->exp < $now->getTimestamp())
        {
            header('HTTP/1.1 401 Unauthorized');
            return ["status" => "Failed authorization", "message"=>"Invalid authorization credentials"];
            exit;
        }

        return ["status" => "Success", "message"=>"Validation successful"];
    }catch(Exception $e){
        return ["status" => "Failed authorization", "message"=>$e->getMessage()] ;
        exit;
    }
}