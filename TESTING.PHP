<?php
include "./connection.php";





    //less coupon 
    $result00 = mysqli_query($conn, "SELECT * FROM `coupons` WHERE `coupon` = 'first50'");
    $row = mysqli_fetch_assoc($result00);
    
    $cartData = json_decode($row['orders'], true);
    array_push($cartData,3);
    print_r($cartData);
    $updatedArray = json_encode($cartData);
    
    // $quantity--;
    $result01 = mysqli_query($conn, "UPDATE `coupons` SET `quantity`='48', `orders` = '$updatedArray' WHERE `coupon` = 'first50'");



?>