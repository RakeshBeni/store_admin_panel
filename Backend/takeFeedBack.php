<?php
include "../connection.php";
if (isset($_POST)) {

  
        $result = mysqli_query($conn, "UPDATE `deliveredorder` SET `feedBack`='$_POST[feedback]' WHERE `OrderId` = '$_POST[orderSr]'");

    if($result){
        header("location:../successfullOrders.php");
    }

}


?>