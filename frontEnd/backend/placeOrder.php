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
    
    $newJsonString = json_encode($data['quantityarray'], JSON_PRETTY_PRINT);
 
    $result = mysqli_query($conn, "INSERT INTO `orders` (`customersId`, `orders`, `phoneNo`, `address`, `timestamp`, `orderValue`) VALUES ('$_SESSION[userId]','$newJsonString', '$phoneNo', '$address','$ddate', '$total') ");
    $emptyCart = '{"length":"0", "product":[]}';
    $result1 = mysqli_query($conn, "UPDATE `customers` SET `Cart`='$emptyCart' WHERE `userId` = '$_SESSION[userId]'");




    if ($result) {
        if($result1){

            echo "success";
        }
    }
}
