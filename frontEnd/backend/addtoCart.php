<?php

include "../connection.php";
session_start();

if (isset($_POST)) {
    $json_data = file_get_contents("php://input");
    $data = json_decode($json_data, true);

    $query = mysqli_query($conn, "SELECT `Cart` FROM `customers` WHERE `userId` = '$_SESSION[userId]'");
    $row1 = mysqli_fetch_assoc($query);
    $cartData = json_decode($row1['Cart'], true);


   
    

    // Add a new object to the "objects" array
    $newObject = array("productId" => "$data[productId]");
    $cartData['length'] = $cartData['length']+1;
    $cartData['product'][] = $newObject;
    
    // Encode the updated data back to JSON
    $newJsonString = json_encode($cartData, JSON_PRETTY_PRINT);
    


    $result = mysqli_query($conn, "UPDATE `customers` SET `Cart`='$newJsonString' WHERE `userId` = '$_SESSION[userId]' ");


    if($result){
        echo "success";
    }


}
