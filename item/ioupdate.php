<?php
$ch = curl_init();
$data = [
    'item_name' => filter_input(INPUT_POST, "item_name"),
    'item_photo' => filter_input(INPUT_POST, "item_photo"),
    'item_description' => filter_input(INPUT_POST, "item_description"),
    'item_price' => filter_input(INPUT_POST, "item_price", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION)
];
curl_setopt($ch, CURLOPT_URL, "http://localhost/Qwerty/nextbid-auction-website-main/api/items/update.php");
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

<h1>item updated</h1>

<p>Repository updated successfully.
 <a href="Ishow.php?item_name=<?php echo $data['item_name']?>">Show</a>
 </p>
 <p>click on <a href="/logedin.php">auction</a> to continue</p>
 </main>
</body>
</html>