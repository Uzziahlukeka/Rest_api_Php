<?php
$name = $_GET['name'];

$apiUrl = "http://localhost/Qwerty/nextbid-auction-website-main/api/user/read_single.php?name=".urlencode($name);

$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_URL => $apiUrl,
    CURLOPT_VERBOSE => true,
    CURLOPT_STDERR => fopen('php://stderr', 'w'),
]);

$response = curl_exec($ch);

$status_code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
curl_close($ch);

$data = json_decode($response, true);


if ($status_code === 422) {
    echo "Invalid data: ";
    print_r($data["errors"]);
    exit;
}

if ($status_code !== 200) {
    echo "Unexpected status code: $status_code";
    var_dump($data);
    exit;
}

// Success
echo "Product added successfully";

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

<h1>User Details</h1>

<form method="post" action="update.php">
        
        <input type="hidden" name="id" value="<?= $data["id"] ?>">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="<?= $data["name"] ?>">
        <label for="email">email</label>
        <textarea name="email" id="email"><?= htmlspecialchars($data["email"]) ?></textarea>
        <button>Submit</button>
    </form>
    <form method="post" action="/logedin.php">
    <button>auction</button>
</form>
</main>
</body>
</html>
