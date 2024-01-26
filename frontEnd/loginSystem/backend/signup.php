<?php
include "../../../connection.php";


if (isset($_POST)) {
    $json_data = file_get_contents("php://input");
    $data = json_decode($json_data, true);



    date_default_timezone_set("Asia/Calcutta");
    $ddate = date('Y-m-d H:i:s');
    // print_r($data);

    $query = mysqli_query($conn, "SELECT * FROM `customers` WHERE `email`= '$data[email]' AND `otp` = '$data[otp]'");
    $rowNum = mysqli_num_rows($query);
    if ($rowNum == 0) {

        die("invalid otp");
    } else {
        $query1 = mysqli_query($conn, "SELECT * FROM `customers` WHERE `email`= '$data[email]' AND `otp` = '$data[otp]' and `otptimeStamp`  >= '$ddate' - INTERVAL 10 MINUTE;");
        $row = mysqli_fetch_assoc($query1);
        $rowNum1 = mysqli_fetch_assoc($query1);
        if ($rowNum1 === 0) {
            die("otp expire");
        } else {
            
            $query2 = mysqli_query($conn, "UPDATE `customers` SET `verified`='1' WHERE `email` = '$data[email]'");
            
            session_start();
            $_SESSION['user'] = "$row[Name]";
            $_SESSION['userId'] = "$row[userId]";
            echo "loginSuccess";

        }
    }


}
