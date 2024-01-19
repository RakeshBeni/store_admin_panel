<?php
include "../connection.php";
    if(isset($_POST)){
        print_r($_POST);

    
        $result = mysqli_query($conn, "SELECT `imgUrl` FROM `product` WHERE `sr` = '$_POST[sr]'");
        if($result){
            $row = mysqli_fetch_assoc($result);

            $filePath = '../'.$row['imgUrl']; 

            if (file_exists($filePath)) {
                if (unlink($filePath)) {
                    echo 'Image deleted successfully.';
                } else {
                    echo 'Unable to delete the image.';
                }
            } else {
                echo 'Image not found.';
            }
        }

        if (isset($_FILES['productPhoto']) && $_FILES['productPhoto']['error'] == 0) {
            $file_tmp = $_FILES['productPhoto']['tmp_name'];

            $filename = uniqid('PP');

            $destinationFolder = "../assets/uploads";
            if (!is_dir($destinationFolder)) {
                mkdir($destinationFolder, 0777, true); 
            }
            move_uploaded_file($file_tmp, $destinationFolder .'/'. $filename . ".png");

            $photolink = 'assets/uploads/'.$filename.".png";
      
            $resutl = mysqli_query($conn, "UPDATE `product` SET `imgUrl`='$photolink' WHERE `sr` = '$_POST[sr]'");
        }
        // header('location:../changeProductDetails.php?sr='.$_POST['sr']);
            
    }
?>