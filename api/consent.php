<?php

declare(strict_types = 1);

header("Access-Control-Cross-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");

require_once "../../config/Database.php";
require_once "../../config/config.php";
require_once "../models/Client.php"; 

//After authorization with email and password, the account owner,
//is asked if the client is allowed to access the scope of data being requested

$db = new DbConnect();

$conn = $db->connect();
$client = new Client($conn);

$data = json_decode(file_get_contents("php://input"));

$client_id = cleanData($conn, $data->client);
$redirect_url = cleanData($conn, $data->redirect_url);
$business_id = cleanData($conn, $data->business_id);

$res = $client->getAClientById($client_id); 
$client_name = $res['name'];

$scope = cleanData($conn, $data->scope);

echo json_encode(["message"=>"{$client_name} will like to access your {$scope}"]);
$is_grant_access = true;

//If consent provided, generate token else, inform the client that access is not granted
if($is_grant_access){
   header("location: token?client={$client_id}&scope={$scope}&redirect_url={$redirect_url}&business_id={$business_id}");
}else{
    header("Location: {$redirect_url}");
}

