<?php
include "./connection.php";
session_start();

if (!isset($_SESSION['user'])) {
    header('location:login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="stylesheet" href="cart.css">
    <style>

.product:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

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

        .cardcss {
            width: 24rem;
            height: 38rem;
        }

        .imagecss {
            object-fit: contain;
            height: 40%;


        }
    </style>
</head>

<body class="bg-dark">

    <?php include './navbar.php' ?>


    <div class="container text-light mt-5">
        <h1 class="text-center m-5" style="margin-bottom: 30px;">Orders Details</h1>


        <div class="shopping-cart">

       

            <div class="accordion" id="accordionExample">
                <?php
                $query2 = mysqli_query($conn, "SELECT * FROM `orders` WHERE `customersId` = '$_SESSION[userId]' ORDER BY `sr` DESC");
                while ($row0 = mysqli_fetch_assoc($query2)) {

                ?>

                    <div class="accordion-item bg-dark text-light">
                        <h2 class="accordion-header">
                            <button class="accordion-button bg-dark text-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $row0['sr'] ?>" aria-expanded="false" aria-controls="collapse<?php echo $row0['sr'] ?>">
                                Order No <?php echo $row0['sr'] ?>  &nbsp &nbsp &nbsp &nbsp &nbsp <span class="text-warning"> Status:</span>   &nbsp<?php 

                                if($row0['orderConfirmation'] == '0'){
                                    echo "<span class='text-danger'> Order Not Confirm Yet!</span>";
                                }else if($row0['orderConfirmation'] == '1' && $row0['trakingNo'] === NULL){
                                    echo "<span class='text-light'> Order Confirmed</span>";
                                }else if($row0['trakingNo'] !== NULL && $row0['FinalStatus'] == 'delivered'){
                                    echo "<span class='text-success'> Order Delivered </span>";
                                }else if($row0['trakingNo'] !== NULL && $row0['FinalStatus'] == 'cancel'){
                                    echo "<span class='text-danger'> Order Cancel</span>";
                                }else if($row0['trakingNo'] !== NULL && $row0['FinalStatus'] === null){
                                    echo "<span class='text-info'> Order Dispatched (TrakingNo: $row0[trakingNo])</span>";
                                }
                                ?>
                            </button>
                        </h2>
                        <div id="collapse<?php echo $row0['sr'] ?>" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">

                                <div class="column-labels">
                                    <label class="product-image">Image</label>
                                    <label class="product-details">Product</label>
                                    <label class="product-price">Flavour</label>
                                    <label class="product-price">Price</label>
                                    <label class="product-quantity">Quantity</label>
                             
                                    <label class="product-line-price">Total</label>
                                </div>
                                <?php
                                $products = json_decode($row0['orders'], true);

                                // print_r($products);
                                foreach ($products as $product0) {

                                    $query3 = mysqli_query($conn, "SELECT * FROM `product` WHERE `sr` = '$product0[productId]'");
                                    $row3 = mysqli_fetch_assoc($query3);

                                ?>

                                    <div class="product">
                                        <div class="product-image">
                                            <img src="../<?php echo $row3['imgUrl'] ?>">
                                        </div>
                                        <div class="product-details">
                                            <div class="product-title"><?php echo $row3['product'] ?></div>
                                            <p class="product-description"><?php echo $row3['description'] ?></p>
                                        </div>
                                        <div class="product-price1"><?php echo $product0['flavour'] ?></div>
                                        <div class="product-price"><?php echo $product0['price'] ?></div>
                                        <div class="product-quantity "><?php echo $product0['quantity'] ?></div>
                                        <div class="product-line-price"><?php echo  $product0['price'] * $product0['quantity'];  ?></div>
                                    </div>

                                <?php     } ?>
                            </div>
                        </div>
                    </div>



                <?php } ?>
            </div>




        </div>


        <!-- Button trigger modal -->


    
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</body>

</html>