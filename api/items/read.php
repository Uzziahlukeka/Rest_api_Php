<?php
//headers for allowing access to the HTTP

header('Access-control-Allow-Origin:*');
header('content-Type:application/json');

include_once '../../config/Database.php';
include_once '../../models/Items.php';

//instantiate DB and connect

$database=new Database();
$db=$database->connect();

//instantiate blog post object
$post=new Items($db);

//blog post query for reading the method called read 
$result=$post->read();

//Get row count 
$num=$result->rowcount();

//check if any posts
if($num>0){
    //post array 
    $posts_arr=array();
    $posts_arr['data']=array();

    while($row=$result->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $post_item=array(
            'item_id'=>$item_id,
            'item_name'=>$item_name,
            'item_photo'=>$item_photo,
            'item_description'=>$item_description,
            'item_price'=>$item_price,
            'item_date'=>$item_date
        );

        //push to data
        array_push($posts_arr['data'],$post_item);
    } 
    //turn to JSON and output
    echo json_encode($posts_arr);

}else{
    //no posts
    echo json_encode(
        array('message'=>'no item found')
    );
    }