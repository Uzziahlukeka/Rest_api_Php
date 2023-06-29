<?php
$name = $_GET['item_name'];

$apiUrl = "http://localhost/Qwerty/nextbid-auction-website-main/api/items/read_single.php?item_name=".urlencode($name);

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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@100;200;300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="icon" href="/icons/Main Logo.svg">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/styles/inner-card.css">
    <title>Nextbid - Auction Website</title>
</head>

<body>


    <section class="card-content">
        <div class="wrapper cards">

            <!-- ............................................................................ -->
            <form method="post" action="ioupdate.php"  >
            <div class="back-button">
                <a href="/logedin.php"><i class="fa-solid fa-arrow-left fa-lg" style="color: #3b3b3b;"></i>  Back</a>
            </div>
            <div class="card auction-card">
                <div class="auction-card-img">
                    <a href="#"><img src="/images/<?php echo $datas['item_photo']?>" alt="Product Image"></a>
                    <input type="hidden" name="item_photo" value="<?php echo $datas['item_photo']?>">
                </div>
                <div class="card-details">
                    <div class="like-icon-num">
                        <a class="like-button">
                            <i class="fa-regular fa-heart fa-lg like1-icon" style="color: #000000;"></i>
                            <i class="fa-solid fa-heart fa-lg" style="color: #f92a2a;"></i>
                        </a>
                        <span class="like-count">0</span>
                    </div>

                    <!-- Title -->
                    <div>
                        <label class="one-label" for="title">Title</label>
                        <h3 class="card-title"><?php echo $datas['item_name']?>
                        <input type="hidden" name="item_name"  value="<?php echo $datas['item_name']?>">
                        </h3>
                    </div>

                    <!-- Description -->
                    <div class="description">
                        <label class="one-label" for="description">Description</label>
                        <input type="text" name="item_description" value="<?php  echo $datas['item_description']?>">
                    </p>
                    </div>
                    <div class="current-price-p">
                        <div class="stroke"></div>
                        <p class="card-text card-text-2">Your bid: <span class="current-price current-bid">$0</span></p>
                        <p class="card-text">Last bid: <span class="current-price last-bid"></span></p>
                            <input type="text" name="item_price" value="<?php echo $datas['item_price']?>">
                    </div>
                    <p class="card-text-last card-text-1">Ends in: <span
                            class="closing-time">2023-04-11T08:00:00Z</span></p>
                    <div class="card-bid">
                        
                        <button type="submit" >submit</button>
                    </div>
                    <p class="card-text-last card-text">Ends in:<span id="timer" class="countdown-timer"></span></p> 
                </div>
            </div>
         
            </form>
        </div>
    </section>
    <script src="/js/script.js"></script>
    <script src="/js/bid.js"></script>
    <script src="/js/like-counter.js"></script>

</body>
</html>