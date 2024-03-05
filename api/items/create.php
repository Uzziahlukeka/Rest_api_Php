<?php 
// Headers for allowing access to the HTTP
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST'); // Allow only POST method
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With'); 

// Include database and item model
include_once '../../config/Database.php';
include_once '../../models/Items.php';

// Instantiate DB and connect
$database = new Database();
$db = $database->connect();

// Get raw posted data
$data = json_decode(file_get_contents('php://input'));

// Check if all required fields are provided
if (
    isset($data->item_name) &&
    isset($data->item_photo) &&
    isset($data->item_description) &&
    isset($data->item_price) &&
    isset($data->user_id)
) {
    // Instantiate item object with database connection
    $post = new Items($db);
    
    // Assign data to the item object
    $post->item_name = $data->item_name;
    $post->item_photo = $data->item_photo;
    $post->item_description = $data->item_description;
    $post->item_price = $data->item_price;
    $post->user_id = $data->user_id;

    // Create post
    if ($post->create()) {
        echo json_encode(array('message' => 'Item created', 'item_name' => $post->item_name));
    } else {
        echo json_encode(array('message' => 'Item not created'));
    }
} else {
    // Required fields are missing
    echo json_encode(array('message' => 'Incomplete data'));
}
?>
