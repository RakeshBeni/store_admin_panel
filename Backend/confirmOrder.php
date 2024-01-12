<?php
include "../connection.php";
if (isset($_POST)) {

    $result = mysqli_query($conn, "UPDATE `orders` SET `address`='$_POST[address]',`orderConfirmation`='1', `confirmationDescription`='$_POST[description]' WHERE `sr` = '$_POST[orderSr]'");

    if($result){
        header("location:../order.php");
    }

}


?>