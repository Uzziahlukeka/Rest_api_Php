<?php 
//headers for allowing access to the HTTP

header('Access-control-Allow-Origin:*');
header('content-Type:application/json');
header('Access-Control-Allow-Methods:POST');//methode for the API 
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-with'); 

include_once '../../config/Database.php';
include_once '../../models/Items.php';

//instantiate DB and connect

$database=new Database();
$db=$database->connect();

//instantiate blog post object
$post=new Items($db);

//get raw posted data
$data=json_decode(file_get_contents('php://input'));

// assign it to the post
$post->item_name=$data->item_name;
$post->item_photo=$data->item_photo;
$post->item_description=$data->item_description;
$post->item_price=$data->item_price;

//create post

if($post->create()){
    echo json_encode(
        array('message'=>'user created','item_name'=>$post->item_name)
    );
} else{
    echo json_encode(
        array('message'=>'user not created')
    );
}