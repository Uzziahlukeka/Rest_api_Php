<?php
//headers for allowing access to the HTTP

header('Access-control-Allow-Origin:*');
header('content-Type:application/json');

include_once '../../config/Database.php';
include_once '../../models/Registration.php';

//instantiate DB and connect

$database=new Database();
$db=$database->connect();

//instantiate blog post object
$post=new Registration($db);

//Get ID
$post->name=isset($_GET['name']) ? $_GET['name'] : die();
//isset then = ? , : else 

//get post
$post->read_single();

//create array 
$post_arr=array(
    'id'=>$post->id,
    'name'=>$post->name,
    'email'=>$post->email
);

//make json 
print_r (json_encode($post_arr));
