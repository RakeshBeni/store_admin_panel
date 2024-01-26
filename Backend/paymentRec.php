<?php
include "../connection.php";
if (isset($_POST)) {


    if (isset($_FILES['paymentImage']) && $_FILES['paymentImage']['error'] == 0) {
        $file_tmp = $_FILES['paymentImage']['tmp_name'];

        $filename = uniqid('PS');

        $destinationFolder = "../assets/payments";
        if (!is_dir($destinationFolder)) {
            mkdir($destinationFolder, 0777, true);
        }
        move_uploaded_file($file_tmp, $destinationFolder . '/' . $filename . ".png");

        $photolink = 'assets/payments/' . $filename . ".png";

        

        $resutl = mysqli_query($conn, "UPDATE `orders` SET `payment`='1', `paymentImage`='$photolink' WHERE `sr` = '$_POST[orderId]'");

        if ($resutl) {
            echo "success";
        }
    }
    if(isset($_POST['Dispatch'])){

        header('location:../dispatchedOrders.php');
    }else{

        
        header('location:../confirmOrders.php');
    }


}
