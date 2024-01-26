<?php 

// $conn = new mysqli('localhost', 'root', '', 'storeadminportal');
include "../../../connection.php";



if (isset($_POST)) {
    $json_data = file_get_contents("php://input");
    $data = json_decode($json_data, true);

    // print_r( $data);
    $query = mysqli_query($conn, "SELECT * FROM customers WHERE `email` = '$data[email]'");
    $isEmailVaild = mysqli_num_rows($query);
    if($isEmailVaild === 0){
        die('inValidEmail');
    }else{
        $query1 = mysqli_query($conn, "SELECT * FROM customers WHERE `email` = '$data[email]' AND BINARY `password` = '$data[pass]'");
        $isPasswordCorrect = mysqli_num_rows($query1);
        if($isPasswordCorrect === 0){
            die('iscorrectPassword');
        }else{
            $row = mysqli_fetch_assoc($query1);

            session_start();
            $_SESSION['user'] = "$row[Name]";
            $_SESSION['userId'] = "$row[userId]";
            echo "loginSuccess";


        }

    }

}

?>