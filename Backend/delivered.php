<?php
include "../connection.php";
if (isset($_POST)) {

    print_r($_POST);

    
    date_default_timezone_set("Asia/Calcutta");
    $ddate = date('Y-m-d H:i:s');

    if(isset($_POST['stage'])){

        $resutl = mysqli_query($conn, "UPDATE `orders` SET `FinalStatus`='$_POST[Status]',`finalDescription`='$_POST[description]' WHERE `sr` = '$_POST[orderId]'");
    }else{

        $resutl = mysqli_query($conn, "UPDATE `orders` SET `FinalStatus`='$_POST[Status]',`finalDescription`='$_POST[description]' WHERE `sr` = '$_POST[orderId]'");
    }



    $result2 = mysqli_query($conn, "SELECT `customersId` FROM `orders` WHERE `sr` = '$_POST[orderId]'");
    $row2 = mysqli_fetch_assoc($result2);

    if($_POST['Status']=="cancel"){

        $result3 = mysqli_query($conn, "INSERT INTO `cancelorders`( `OrderId`, `customerId` , `TIMESTAMP` ) VALUES ('$_POST[orderId]','$row2[customersId]', '$ddate')");
    }else{
        $result3 = mysqli_query($conn, "INSERT INTO `deliveredorder`( `OrderId`, `customerId`, `TIMESTAMP`) VALUES ('$_POST[orderId]','$row2[customersId]', '$ddate')");

    }

    if ($resutl) {
        echo "success";
        // header('location:../dispatchedOrders.php');
    }

}