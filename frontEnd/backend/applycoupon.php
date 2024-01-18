<?php

include "../connection.php";
session_start();

if (isset($_POST)) {
    $json_data = file_get_contents("php://input");
    $data = json_decode($json_data, true);
    // print_r($data);

    $result = mysqli_query($conn, "SELECT * FROM `coupons` WHERE `coupon` = '$data[coupon]'");
    $rownum = mysqli_num_rows($result);
    if ($rownum > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($row['quantity'] > 0) {

            $data = array(
                'status' => 'Success',
                'discount' => $row['discount']
            );
        } else {
            $data = array(
                'status' => 'expire',
                'message' => 'coupon expire'
            );
        }
    } else {

        $data = array(
            'status' => 'Invalid',
            'message' => 'Invalid code'
        );
    }


    // Set the content type to application/json
    header('Content-Type: application/json');

    // Output the JSON-encoded data
    echo json_encode($data);
}
