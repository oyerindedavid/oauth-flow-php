<?php

declare(strict_types = 1);

header("Access-Control-Cross-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");

require_once "../../config/Database.php";
require_once "../../config/config.php";
require_once "../models/Business.php"; 

//This is the authorization api where the user is expected to enter email and password of the 
//account where access is being required, in our case business account.

$db = new DbConnect();

$conn = $db->connect();

$business = new Business($conn);

$data = json_decode(file_get_contents("php://input"));

$client_id = cleanData($conn, $data->client_id);
$scope = cleanData($conn, $data->scope);
$redirect_url = cleanData($conn, $data->redirect_url);

//In real app, email and password will be collected with form input field
$email = cleanData($conn, $data->email); 
$password = cleanData($conn, $data->password);

$response = $business->isExistBusinessAccount($email, $password);

//if authorization credential is correct, redirect user to consent page
if($response['is_exist']){
    header("Location: consent?client={$client_id}&scope={$scope}&redirect_url={$redirect_url}");
}

