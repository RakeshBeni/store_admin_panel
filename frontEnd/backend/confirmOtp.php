<?php
include "../connection.php";
session_start();

if (isset($_GET['otp'])) {
    date_default_timezone_set("Asia/Calcutta");
    $ddate = date('Y-m-d H:i:s');

    $query1 = mysqli_query($conn, "SELECT * FROM `customers` WHERE `userId` = '$_SESSION[userId]' AND `otp` = '$_GET[otp]' ");
    $row1 = mysqli_fetch_assoc($query1);
    if($row1 == 0){
        die("otp invalid");
    }else{
        $query = mysqli_query($conn, "SELECT * FROM `customers` WHERE `userId` = '$_SESSION[userId]' AND `otp` = '$_GET[otp]' and `otptimeStamp`  >= '$ddate' - INTERVAL 10 MINUTE;");
        $row = mysqli_fetch_assoc($query);
        if($row == 0){
            die('otp expire');
        }else{
            $query2 = mysqli_query($conn, "UPDATE `customers` SET `verifiedPhoneNo`='1' WHERE `userId` = '$_SESSION[userId]'");
            echo "verified";
            die();
        }
    }

}

?>