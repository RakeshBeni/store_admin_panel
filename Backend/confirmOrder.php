<?php
include "../connection.php";
if (isset($_POST)) {

    if(isset($_POST['address'])){

        $result = mysqli_query($conn, "UPDATE `orders` SET `address`='$_POST[address]',`orderConfirmation`='1', `confirmationDescription`='$_POST[description]' WHERE `sr` = '$_POST[orderSr]'");
    }elseif(isset($_POST['trackingId'])){
        $result = mysqli_query($conn, "UPDATE `orders` SET `trakingNo`='$_POST[trackingId]', `dispatchDescription`='$_POST[description]' WHERE `sr` = '$_POST[orderSr]'");

    }


    if($result){
        header("location:../order.php");
    }

}


?>