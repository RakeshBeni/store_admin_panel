<?php 

include "../connection.php";

if(isset($_POST)){
    $json_data = file_get_contents("php://input");
    $data = json_decode($json_data, true);
    // print_r($data);


    if($data['type'] == "Stock"){
        if($data['productStatus'] == 1){
            mysqli_query($conn, "UPDATE `product` SET `instock`='0' WHERE `sr` ='$data[productSr]'");
            echo "success";
        }else{
            mysqli_query($conn, "UPDATE `product` SET `instock`='1' WHERE `sr` ='$data[productSr]'");
            echo "success";
        }
    }elseif($data['type'] == "visible"){
        if($data['productStatus'] == 1){
            mysqli_query($conn, "UPDATE `product` SET `isvisible`='0' WHERE `sr` ='$data[productSr]'");
            echo "success";
        }else{
            mysqli_query($conn, "UPDATE `product` SET `isvisible`='1' WHERE `sr` ='$data[productSr]'");
            echo "success";
        }
    }

}


?>