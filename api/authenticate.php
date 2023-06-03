<?php
declare(strict_types = 1);

header("Access-Control-Cross-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");

require_once "../config/Database.php";
require_once "../config/config.php";
require_once "../models/Token.php";
require_once "../helper/helper.php";

use Firebase\JWT\JWT;

$db = new DbConnect();
$conn = $db->connect();

$data = json_decode(file_get_contents('php://input'));

$business_id = cleanData($conn, $data->business_id);
$client_id = cleanData($conn, $data->client_id);
$client_secrete = cleanData($conn, $data->client_secrete);

//Authenticate user and provide access token
if(isValidLoginCredention()){
    $secrete_key = $client_secrete;
    $issued_at = new DateTimeImmutable();
    $expire = $issued_at->modify('+10 minutes')->getTimestamp();  //Add 10 minutes
    $server_name = "localhost"; //Domain name e.g www.domain.com

    $data = [
     'iat' => $issued_at->getTimestamp(), // Issued at: time when the token was generated
     'iss' => $server_name,               // Issuer
     'nbf' => $issued_at->getTimestamp(), // Not before
     'exp' => $expire,                    // Expire
    ];

    //Generate token
    $access_token = JWT::encode($data, $secrete_key, 'HS512');

    //Save token data to database
    $token = new Token($conn);
    $token->createtoken(business_id:$business_id, client_id:$client_id, token:$access_token);

    echo $access_token;

 }else{
    echo ["status"=>401, "Invalid login credentials provided"];
 }

