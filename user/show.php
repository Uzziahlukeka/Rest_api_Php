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
<dl>
    <dt>ID</dt>
    <dd><?php echo $datas['id']; ?></dd>
    <dt>Name</dt>
    <dd><?php echo $datas['name']; ?></dd>
    <dt>Email</dt>
    <dd><?php echo htmlspecialchars($datas['email']); ?></dd>
</dl>

<form method="post" action="edit.php?name=<?php echo $datas['name']; ?>">
    <button>Edit</button>
</form>
<form method="post" action="delete.php">
    <input type="hidden" name="id" value="<?php echo $datas['id']; ?>">
    <button>Delete</button>
</form>
<form method="post" action="/logedin.php">
    <button>auction</button>
</form>


</main>
</body>
</html>
