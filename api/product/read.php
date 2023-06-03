<?php
declare(strict_types = 1);

header("Access-Control-Cross-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");

require_once "../../config/Database.php";
require_once "../../config/config.php";
require_once "../../models/Product.php";
require_once "../validate.php";


$db = new DbConnect();
$conn = $db->connect();

$product = new Product($conn);

try{
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $result = $product->getAProductById($id);
    }else{
        $result = $product->getAllProduct();
    }
    
    echo json_encode($result);
    
}catch(Exception $e){
    $response['status'] = 'Failed';
    $response['message'] = $e->getMessage();

    echo json_encode($response);
}



