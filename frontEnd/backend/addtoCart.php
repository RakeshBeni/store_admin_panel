<?php

include "../connection.php";
session_start();

if (isset($_POST)) {
    $json_data = file_get_contents("php://input");
    $data = json_decode($json_data, true);

    $query = mysqli_query($conn, "SELECT `Cart` FROM `customers` WHERE `userId` = '$_SESSION[userId]'");
    $row1 = mysqli_fetch_assoc($query);
    $cartData = json_decode($row1['Cart'], true);

    $flavours = $data['flavours'];



    foreach ($flavours as $flavour) {

        $bothExist = false;


        foreach ($cartData['product'] as $item) {
            if ($item['productId'] == $data['productId'] && $item['flavour'] == $flavour) {
                $bothExist = true;
                continue;
            }
        }

        if ($bothExist) {
            continue;
        }
        $newObject = array("productId" => "$data[productId]", "flavour" => "$flavour");
        $cartData['length'] = $cartData['length'] + 1;
        $cartData['product'][] = $newObject;
        // Encode the updated data back to JSON
        $newJsonString = json_encode($cartData, JSON_PRETTY_PRINT);



        $result = mysqli_query($conn, "UPDATE `customers` SET `Cart`='$newJsonString' WHERE `userId` = '$_SESSION[userId]' ");
    }






   
        echo "success";
    
}
