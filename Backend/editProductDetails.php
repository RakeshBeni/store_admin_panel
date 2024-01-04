<?php 

include "../connection.php";

if(isset($_POST)){
    $json_data = file_get_contents("php://input");
    $data = json_decode($json_data, true);
    print_r($data);

    mysqli_query($conn, "UPDATE `product` SET `product`='$data[tital]',`mrp`='$data[mrp]',`sellingPrice`='$data[sellingPrice]',`description`='$data[cartDescription]' WHERE `sr` = '$data[sr]'");


   

}


?>