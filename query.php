<?php
header("Access-control-cross-origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once "../../config/Database.php";
require_once "../../models/Product.php";
require_once "../../models/Business.php";
require_once "../../models/Client.php";

$db = new DbConnect();

$conn = $db->connect();

$product = new Product($conn);
$business = new Business($conn);
$client = new Client($conn);

$product_data = file_get_contents('data/product.json');
$business_date = file_get_contents('data/business.json');
$client_data = file_get_contents('data/client.json');

$json_product = json_decode($product_data, true);
$json_business = json_decode($business_date, true);
$json_client = json_decode($client_data, true);

//Create demo business and client account
$business->createBusiness($json_business['name'], $json_business['email'], $json_business['password']);
$client->createClient($json_client['name']);

//Creating dummy products
foreach($json_product['data'] as $prd){
    try{
        $res = $product->createProduct($prd['name'], $prd['price'], $prd['category_id']);
        $response['status'] = 'Success';
        $response['message'] = 'Product added';

        echo $response;
    }catch(Exception $e){
        $response['status'] = 'Failed';
        $response['message'] = $e->getMessage();

        print_r($response) ;
    }  
} 

