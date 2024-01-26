<?php
include "./connection.php";
if(!isset($_GET['OrderId'])){
    header("location:./index.php");
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/style.css">
    <style>
        ::-webkit-scrollbar {
            width: 5px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            box-shadow: inset 0 0 5px grey;
            border-radius: 5px;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #dde0e3;
            border-radius: 5px;
        }

        .custom-file-button input[type="file"] {
            margin-left: -2px !important;
        }

        .custom-file-button input[type="file"]::-webkit-file-upload-button {
            display: none;
        }

        .custom-file-button input[type="file"]::file-selector-button {
            display: none;
        }

        .custom-file-button:hover label {
            background-color: #dde0e3;
            cursor: pointer;
        }

        .hidden {
            display: none;
        }
    </style>
</head>

<body class="bg-dark">
    <?php include './navbar.php'; ?>

    <div class="container mt-4">
        <center>
            <div class="btn-group"><button type="button" class="btn btn-secondary btn-lg shadow" disabled><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-video" viewBox="0 0 16 16">
                        <path d="M8 9.05a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5" />
                        <path d="M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zm10.798 11c-.453-1.27-1.76-3-4.798-3-3.037 0-4.345 1.73-4.798 3H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1z" />
                    </svg> &nbsp Customers </button>


            </div>
        </center>
        <div class="mt-5">
        <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th scope="col">Order Id</th>
                        <th scope="col">Status</th>
                        <th scope="col">Time</th>
                        <th scope="col">Name</th>
                        <th scope="col">Phone No</th>
                        <th scope="col">Address</th>
                        <th scope="col">Order Value</th>
                        <th scope="col">Products</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $index = 0;
                    $result = mysqli_query($conn, "SELECT * FROM orders  WHERE `sr` = '$_GET[OrderId]';");
                    while ($row = mysqli_fetch_assoc($result)) {
                       
                    ?>
                        <tr>
                            
                            <th scope="row"><?php echo $row['sr']; ?></th>
                            
                            <td><?php if ($row['FinalStatus']) {
                                                                        echo "<span class='text-success'>Successfull</span>";
                                                                    } elseif ($row['trakingNo'] !== null) {
                                                                        echo "   <span class='text-success'>Order Dispatched</span>";
                                                                    } elseif ($row['orderConfirmation'] == '1') {
                                                                        echo "   <span class='text-info'>Order Confirmed</span>";
                                                                    } else {
                                                                        echo "<span class='text-warning'>order Placed</span>";
                                                                    } ?></td>
                            <td><?php echo $row['timestamp']; ?></td>
                            <td><?php $result1 = mysqli_query($conn, "SELECT `Name` FROM `customers` WHERE `userId` = '$row[customersId]'");
                                $row1 = mysqli_fetch_assoc($result1);
                                echo $row1['Name']; ?></td>
                            <td><?php echo $row['phoneNo']; ?></td>
                            <td><?php echo $row['address']; ?></td>
                            <td><?php echo $row['orderValue']; ?></td>

                            <td><!-- Button trigger modal -->
                                <button type="button" class="btn <?php if ($row['payment'] === '0') {
                                                                        echo 'btn-outline-success';
                                                                    } else {
                                                                        echo 'btn-success';
                                                                    } ?> btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $row['sr'] ?>">
                                    Products
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal<?php echo $row['sr'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl" style="color:black">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Order Details</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <?php if($row['coupon'] != null){echo "<h4 class='text-success'> Coupon Applied : $row[coupon]   of <span class='text-warning'>  $row[discount] Rupess</span> </h4><hr> ";}?>
                                                <h3 class="text-success"><?php if($row['trakingNo'] !== null){echo 'Track Id : '.$row['trakingNo'];}?>  </h3>

                                                <p> <?php if($row['dispatchDescription'] !== ''){echo 'Description : '.$row['dispatchDescription'];}?>  </p>
                                                
                                                <div class="m-5">

                                                    <table class="table table-striped border border-secondary text-center">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Index</th>
                                                                <th scope="col">Product</th>
                                                                <th scope="col">Flavour</th>
                                                                <th scope="col">Quantity</th>
                                                                <th scope="col">Price</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $products = json_decode($row['orders'], true);
                                                            foreach ($products as $INDEX0 => $product) {
                                                                $result2 = mysqli_query($conn, "SELECT * FROM `product` WHERE `sr` = '$product[productId]' ");
                                                                $row2 = mysqli_fetch_assoc($result2);
                                                                $productName = $row2['product'];
                                                                $productWeight = $row2['weight'];
                                                            ?>

                                                                <tr>
                                                                    <th scope="row"><?php echo $INDEX0 + 1; ?></th>
                                                                    <td><?php echo $productName;
                                                                        echo $productWeight ?></td>
                                                                    <td><?php echo $product['flavour'] ?></td>
                                                                    <td><?php echo $product['quantity'] ?></td>

                                                                    <td><?php echo $product['price'] ?></td>
                                                                </tr>

                                                            <?php } ?>


                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <?php if ($row['payment'] === '1') {
                                                    echo ' <button type="button" class="btn  btn-success"  data-bs-toggle="modal" data-bs-target="#paymentImage" data-bs-image="' . $row['paymentImage'] . '">Payment Image</button>';
                                                } ?>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                 
                        </tr>

                    <?php } ?>

                </tbody>
            </table>
         
        </div>




    </div>





    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


</body>


</html>