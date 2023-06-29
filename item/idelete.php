<?php
$apiUrl = "http://localhost/Qwerty/nextbid-auction-website-main/api/items/delete.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the item name from the hidden input field
    $item_name = $_POST["item_name"];

    // Create an array with the data to send in the request
    $data = array(
        "item_name" => $item_name
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

<h1>item removed from the auction</h1>
 <p>click on <a href="/logedin.php">auction</a> to continue</p>
 </main>
</body>
</html>