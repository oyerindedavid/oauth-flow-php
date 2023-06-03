<?php
declare(strict_types = 1);

header("Access-Control-Cross-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");

require_once "../../config/Database.php";
require_once "../../config/config.php";
require_once "../../models/Business.php";


$db = new DbConnect();
$conn = $db->connect();

$business = new Business($conn);

try{
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $result = $business->getAbusinessById($id);
    }else{
        $result = $business->getAllBusiness();
    }
    echo json_encode($result);
}catch(Exception $e){
    $response['status'] = 'Failed';
    $response['message'] = $e->getMessage();

    echo json_encode($response);
}





