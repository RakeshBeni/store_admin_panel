<?php
include "../connection.php";
if (isset($_POST)) {

    print_r($_POST);


    $resutl = mysqli_query($conn, "UPDATE `orders` SET `FinalStatus`='$_POST[Status]',`finalDescription`='$_POST[description]' WHERE `sr` = '$_POST[orderId]'");

    $result2 = mysqli_query($conn, "SELECT `customersId` FROM `orders` WHERE `sr` = '$_POST[orderId]'");
    $row2 = mysqli_fetch_assoc($result2);

    if($_POST['Status']=="cancel"){

        $result3 = mysqli_query($conn, "INSERT INTO `cancelorders`( `OrderId`, `customerId`, `Remarks`) VALUES ('$_POST[orderId]','$row2[customersId]','$_POST[description]')");
    }else{
        $result3 = mysqli_query($conn, "INSERT INTO `deliveredorder`( `OrderId`, `customerId`, `feedBack`) VALUES ('$_POST[orderId]','$row2[customersId]','$_POST[description]')");

    }

    if ($resutl) {
        echo "success";
        header('location:../dispatchedOrders.php');
    }

}