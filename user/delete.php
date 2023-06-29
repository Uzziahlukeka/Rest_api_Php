<?php
$apiUrl = "http://localhost/Qwerty/nextbid-auction-website-main/api/user/delete.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the item name from the hidden input field
    $id = $_POST["id"];

    // Create an array with the data to send in the request
    $data = array(
        "id" => $id
    );

    // Initialize cURL and set the request options
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute the request
    $response = curl_exec($ch);

    // Get the response status code
    $status_code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);

    // Close the cURL session
    curl_close($ch);

    // Check if the request was successful
    if ($status_code === 204) {
        echo "Unexpected status code: $status_code";
        var_dump($data);    
    exit;
    } 
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Example REST API Client</title>
    <link rel="stylesheet" href="https://unpkg.com/@picocss/pico@latest/css/pico.classless.min.css">
</head>
<body>
    
    <main>

<h1>user deleted</h1>
 <p>thank you <a href="/index.php">log out</a> to continue</p>
 </main>
</body>
</html>