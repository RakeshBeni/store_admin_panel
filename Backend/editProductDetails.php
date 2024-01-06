<?php 

include "../connection.php";

if(isset($_POST)){
    $json_data = file_get_contents("php://input");
    $data = json_decode($json_data, true);

    $flavourJson = json_encode(['flavour' => $data['flavour']]);


$result = mysqli_query($conn, "UPDATE `product` SET `product`='$data[tital]',`weight`= '$data[weight]',`mrp`='$data[mrp]', `flavour`= '$flavourJson',`sellingPrice`='$data[sellingPrice]',`description`='$data[cartDescription]' WHERE `sr` = '$data[sr]'");

if($result){
    echo "success";
}
   

}


?>