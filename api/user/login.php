<?php
// login.php

//headers for allowing access to the HTTP
header('Access-control-Allow-Origin:*');
header('content-Type:application/json');

include_once '../../config/Database.php';
include_once '../../models/Registration.php';

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get POST data
    $data = json_decode(file_get_contents("php://input"));
    
    // Validate input
    if (!empty($data->email) && !empty($data->password)) {
        // Instantiate Database and connect
        $database = new Database();
        $db = $database->connect();
        
        // Instantiate User object
        $user = new Registration($db);
        
        // Call login method
        if ($user->login($data->email, $data->password)) {
            // Login successful
            echo json_encode(array('message' => 'Login successful', 'name' => $user->name));
        } else {
            // Login failed
            echo json_encode(array('message' => 'Login failed'));
        }
    } else {
        // Invalid input
        http_response_code(400);
        echo json_encode(array('message' => 'Invalid input'));
    }
} else {
    // Invalid request method
    http_response_code(405);
    echo json_encode(array('message' => 'Method Not Allowed'));
}
