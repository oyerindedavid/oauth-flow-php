<?php
declare(strict_types = 1);

header("Access-Control-Cross-Origin: *");
header("Access-Control-Allow-Methods: DELETE");
header("Content-Type: application/json; charset=UTF-8");

require_once "../../config/Database.php";
require_once "../../config/config.php";
require_once "../../models/Product.php";
require_once "../../models/Token.php";
require_once "../../helper/helper.php";

$db = new DbConnect();
$conn = $db->connect();

$product = new Product($conn);

//Valid the access token
$response = validateToken($conn); 
if($response['status'] === "Success"){
    $prod = json_decode(file_get_contents("php://input"));

    try{
        $res = $product->delete($prod->id);

        $response['status'] = 'Success';
        $response['message'] = 'Product deleted successfully';

        echo json_encode($response);
    }catch(Exception $e){
        $response['status'] = 'Failed';
        $response['message'] = $e->getMessage();

        echo json_encode($response);
    }
}else{
    echo json_encode($response);
}




