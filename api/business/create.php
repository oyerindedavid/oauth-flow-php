<?php
declare(strict_types = 1);

header("Access-Control-Cross-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");

require_once "../../config/Database.php";
require_once "../../config/config.php";
require_once "../../models/Business.php";
require_once "../../helper/helper.php";

$db = new DbConnect();

$conn = $db->connect();

$business = new Business($conn);

$data = json_decode(file_get_contents("php://input"));

$name = cleanData($conn, $data->name);
$email = cleanData($conn, $data->email);
$password = cleanData($conn, $data->password);

try{
    $business->createBusiness(name: $name, email:$email, password:$password);

    $response['status'] = 'Success';
    $response['message'] = 'Business account created';

    echo json_encode($response);
}catch(Exception $e){
    $response['status'] = 'Failed';
    $response['message'] = $e->getMessage();

    echo json_encode($response);
}