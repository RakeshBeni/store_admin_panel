<?php
include "../connection.php";
if (isset($_POST)) {


    if (isset($_FILES['productPhoto']) && $_FILES['productPhoto']['error'] == 0) {
        $file_tmp = $_FILES['productPhoto']['tmp_name'];

        $filename = uniqid('PP');

        $destinationFolder = "../assets/uploads";
        if (!is_dir($destinationFolder)) {
            mkdir($destinationFolder, 0777, true);
        }
        move_uploaded_file($file_tmp, $destinationFolder . '/' . $filename . ".png");

        $photolink = 'assets/uploads/' . $filename . ".png";

        // Extract the string from the original array
        $flavourString = $_POST['flavour'][0];

        // Split the string into an array using ',' as the delimiter
        $flavourArray = explode(',', $flavourString);

        // Remove any leading or trailing whitespaces from each flavor
        $flavourArray = array_map('trim', $flavourArray);

        $flavourJson = json_encode(['flavour' => $flavourArray]);

        $resutl = mysqli_query($conn, "INSERT INTO `product`( `product`, `category`, `weight`, `imgUrl`, `flavour`, `mrp`, `sellingPrice`, `description`) VALUES ('$_POST[product]','$_POST[category]','$_POST[weight]','$photolink','$flavourJson','$_POST[mrp]','$_POST[sellingPrice]','$_POST[description]')");

        if ($resutl) {
            echo "success";
        }
    }

    // header('location:../index.php');


}
