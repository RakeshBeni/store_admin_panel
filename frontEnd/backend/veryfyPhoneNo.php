<?php

include "../connection.php";
session_start();
if(isset($_GET)){ 

 date_default_timezone_set("Asia/Calcutta");
 $ddate = date('Y-m-d H:i:s');
 $randomCode = rand(100000, 999999);

 $query = mysqli_query($conn, "UPDATE `customers` SET `phoneNo`='$_GET[phoneNO]',`otp`='$randomCode',`otptimeStamp`='$ddate' WHERE `userId` = '$_SESSION[userId]'");

 $apiUrl = "https://www.fast2sms.com/dev/bulkV2?authorization=mU68Nsxwb1FiZWEpXcPgJt9uIMrTeyHzGva7OfqSo2Dl50njRkZ8RvSHxJBEUGTuyD6C5z3pQhceos71&route=otp&variables_values=$randomCode&flash=0&numbers=$_GET[phoneNO]";

//  echo $apiUrl;
 $response = file_get_contents($apiUrl);
 if ($response === false){
    // Handle error
    echo "Error fetching data.";
} else {
    // Parse the JSON content of the response
    $data = json_decode($response, true);
    if($data['message'][0] === "SMS sent successfully."){
        die("successfull");
    }
}
}

?>