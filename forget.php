<?php
  // forget 
include_once '../nextbid-auction-website-main/config/Database.php';
$database=new Database();
$con=$database->connect();

if (filter_has_var(INPUT_POST, "submit")) {
    $email = filter_input(INPUT_POST, "email");

    // Check if the email exists in the database
    $query = "SELECT * FROM registration WHERE email = :email";
    $stmt = $con->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {

        $sorti="SELECT password FROM registration WHERE email= :email";
        $resetLink=$con->prepare($sorti);
        $resetLink->bindParam(':email', $email);
        $resetLink->execute();
        $rest=$resetLink->fetchAll(PDO::FETCH_ASSOC);

        //var_dump($rest);
        if (!empty($rest)) {
    
        $to = $email;
        $subject = "Password Reset";
        $message = "your password has been sent :" .$rest[0]['password'];
        $hearders="from : uzziah luk ";
        // Send the email
        $uzhh=mail($to, $subject, $message,$hearders);
        // Display a success message to the user
        
        if($uzhh==true){
            header("location:index.php");
            echo "Password reset link has been sent to your email.";
            exit();
        }
        else{
        echo 'sorry uzh'; 
            }
        }
    
    } 
    else {
        // Email does not exist in the database
        echo "Invalid email address.";
        }
}
?>