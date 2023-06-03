<?php
declare(strict_types = 1);

header("Access-Control-Cross-Origin: *");
header("Access-Control-Allow-Methods: PUT");
header("Content-Type: application/json; charset=UTF-8");

require_once "../../config/Database.php";
require_once "../../config/config.php";
require_once "../../models/Client.php";
require_once "../../helper/helper.php";

$db = new DbConnect();

$conn = $db->connect();

//Instantiate client class
$client = new Client($conn);

$data = json_decode(file_get_contents("php://input"));

$client_id = cleanData($conn, $data->client_id);

try{
    $client->updateClient($client_id);
    
    $response['status'] =  "Success";
    $response['message'] = 'Client updated successfully';

    echo json_encode($response);
}catch(Exception $e){
    $response['status'] = 'Failed';
    $response['message'] = $e->getMessage();

    echo json_encode($response);
}
