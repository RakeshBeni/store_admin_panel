<?php

include "../../../connection.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// include "../connection.php";
// session_start();

if (isset($_POST)) {
    $json_data = file_get_contents("php://input");
    $data = json_decode($json_data, true);

    $email = strtolower($data['email']);


    date_default_timezone_set("Asia/Calcutta");
    $ddate = date('Y-m-d H:i:s');



    $randomCode = rand(100000, 999999);

    // Load PHPMailer Autoloader
    require './PHPMailer-master/src/PHPMailer.php';
    require './PHPMailer-master/src/Exception.php';
    require './PHPMailer-master/src/SMTP.php';

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {

        $query1 = mysqli_query($conn, "SELECT * FROM `customers` WHERE `email` = '$email'");
        $rownum = mysqli_num_rows($query1);

        $hashed_password = sha1($data['pass']);

        if ($rownum == 0) {
            $query = mysqli_query($conn, "INSERT INTO `customers`( `Name`, `email`,  `password`, `otp`, `otptimeStamp`) VALUES ('$data[name]','$email','$hashed_password','$randomCode','$ddate')");
        } else {
            $query2 = mysqli_query($conn, "SELECT * FROM `customers` WHERE `email` = '$email' AND `verified` = '1'");
            $rownum2 = mysqli_num_rows($query2);
            if ($rownum2 == 0){
                
                $query = mysqli_query($conn, "UPDATE `customers` SET `Name`='$data[name]',`password`='$hashed_password',`otp`='$randomCode',`otptimeStamp`='$ddate' WHERE `email` = '$email'");
            } else {
                die('Already Email');
            }
        }


        $mail->isSMTP();
        $mail->Host       = 'smtp.hostinger.com'; // Replace with your SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'verify@digidark.in'; // Replace with your SMTP username (your email)
        $mail->Password   = '45ToqvQIFzjO9PECW#'; // Replace with your SMTP password
        $mail->SMTPSecure = 'ssl'; // Use 'ssl' or 'tls' depending on your server configuration
        $mail->Port       = 465; // Replace with your SMTP port

        // Recipients
        $mail->setFrom('verify@digidark.in', 'Digidark'); // Replace with your sender email and name
        $mail->addAddress($email, $data['name']); // Replace with the recipient's email and name

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Verification Code';
        $mail->Body    = 'Your verification code is: ' . $randomCode; // Replace with your actual verification code

        $mail->send();
        echo 'Email Send';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
