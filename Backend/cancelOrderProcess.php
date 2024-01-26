<?php
include "../connection.php";
if (isset($_POST)) {
    print_r($_POST);

  
        $result = mysqli_query($conn, "UPDATE `cancelorders` SET `Remarks`='$_POST[description]' WHERE `OrderId` = '$_POST[OrderNo]'");

    if($result){
        header("location:../CancelOrders.php");
    }

}


?>