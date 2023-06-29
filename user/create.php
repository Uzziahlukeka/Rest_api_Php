<?php
$data = [
    'name' => filter_input(INPUT_POST, "name",),
    'email' => filter_input(INPUT_POST, "email"),
    'passw' => filter_input(INPUT_POST, "password")
];

$apiUrl = "http://localhost/Qwerty/nextbid-auction-website-main/api/user/create.php";

$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_URL => $apiUrl,
    CURLOPT_POSTFIELDS => json_encode($data),
    CURLOPT_VERBOSE => true,
    CURLOPT_STDERR => fopen('php://stderr', 'w'),
]);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    $error = curl_error($ch);
    echo "cURL Error: " . $error;
    exit;
}

$status_code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
curl_close($ch);

$datas = json_decode($response, true);

if ($status_code === 422) {
    echo "Invalid data: ";
    print_r($datas["errors"]);
    exit;
}

if ($status_code !== 200) {
    echo "Unexpected status code: $status_code";
    var_dump($datas);
    exit;
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

<h1>WELCOME</h1>

<p> created successfully.
    <p>click on <a href="../index.php">auction</a> to continue</p>
    <p>go to your profil <a href="show.php?name=<?php echo $data['name'] ; ?>"> go on </a></p>
    
</p>

</main>
</body>
</html>