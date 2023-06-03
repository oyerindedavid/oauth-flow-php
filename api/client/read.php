<?php
declare(strict_types = 1);

header("Access-Control-Cross-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");

require_once "../../config/Database.php";
require_once "../../config/config.php";
require_once "../../models/Client.php";


$db = new DbConnect();
$conn = $db->connect();

$client = new Client($conn);

try{
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $result = $client->getAClientById($id);
    }else{
        $result = $client->getAllClient();
    }
    
    echo json_encode($result);
}catch(Exception $e){
    $response['status'] = 'Failed';
    $response['message'] = $e->getMessage();

    echo json_encode($response);
}




