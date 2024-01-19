<?php
include "../connection.php";
session_start();

if (isset($_POST)) {
    $json_data = file_get_contents("php://input");
    $data = json_decode($json_data, true);
 

    date_default_timezone_set("Asia/Calcutta");
    $ddate = date('Y-m-d H:i:s');

    $total = $data['total'];
    $address = $data['address'];
    $phoneNo = $data['phoneNo'];
    $coupon = $data['coupon'];
    $discount = $data['discount'];
    
    $newJsonString = json_encode($data['quantityarray'], JSON_PRETTY_PRINT);
  

    $result1 = mysqli_query($conn, "UPDATE `customers` SET `phoneNo`='$phoneNo',`address`='$address' WHERE `userId` = '$_SESSION[userId]'");

    //add in orders
 
    $result = mysqli_query($conn, "INSERT INTO `orders` (`customersId`, `orders`, `phoneNo`, `address`, `discount`, `coupon`,`timestamp`, `orderValue`) VALUES ('$_SESSION[userId]','$newJsonString', '$phoneNo', '$address', '$discount', '$coupon' ,'$ddate', '$total') ");


    if ($result) {
        // Retrieve the ID of the last inserted row
        $lastInsertId = mysqli_insert_id($conn);
    
        $result00 = mysqli_query($conn, "SELECT * FROM `coupons` WHERE `coupon` = '$coupon'");
        $row00 = mysqli_fetch_assoc($result00);


        $cartData = json_decode($row00['orders'], true);
        array_push($cartData,$lastInsertId);

        $updatedArray = json_encode($cartData);

        $quantity = $row00['quantity'];
        $quantity--;
        $result01 = mysqli_query($conn, "UPDATE `coupons` SET `quantity`='$quantity', `orders` = '$updatedArray' WHERE `coupon` = '$coupon'");
     
    }

    //less coupon 



    //empty cart
    $emptyCart = '{"length":"0", "product":[]}';
    $result1 = mysqli_query($conn, "UPDATE `customers` SET `Cart`='$emptyCart' WHERE `userId` = '$_SESSION[userId]'");




    if ($result) {
        if($result1){

            echo "success";
        }
    }
}
