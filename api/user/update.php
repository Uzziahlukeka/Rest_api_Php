<?php
//headers for allowing access to the HTTP

header('Access-control-Allow-Origin:*');
header('content-Type:application/json');
header('Access-Control-Allow-Methods:PUT');//methode for the API 
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-with'); 


include_once '../../config/Database.php';
include_once '../../models/Registration.php';

//instantiate DB and connect

$database=new Database();
$db=$database->connect();

//instantiate blog post object
$post=new Registration($db);

//get raw posted data
$data=json_decode(file_get_contents('php://input'));

//set ID to update
$post->id=$data->id;

// assign it to the post
$post->name=$data->name;
$post->email=$data->email;

//update post

if($post->update()){
    echo json_encode(
        array('message'=>'user update')
    );
} else{
    echo json_encode(
        array('message'=>'user not update')
    );
}