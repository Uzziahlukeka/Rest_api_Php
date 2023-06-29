<?php
$ch = curl_init();
$data = [
    'id' => filter_input(INPUT_POST, "id"),
    'name' => filter_input(INPUT_POST, "name"),
    'email' => filter_input(INPUT_POST, "email")
];
curl_setopt($ch, CURLOPT_URL, "http://localhost/Qwerty/nextbid-auction-website-main/api/user/update.php");
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

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

<h1>user updated</h1>

<p>Repository updated successfully.
<p>votre profil
 <a href="show.php?name=<?php echo $data ['name']?>">Show</a>
 </p>
</p>
 <p>click on <a href="/logedin.php">auction</a> to continue</p>
 </main>
</body>
</html>