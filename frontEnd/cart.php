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
</head>

<body class="bg-dark">

    <nav class="navbar bg-dark border-bottom border-body navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>

                </ul>
                <div class="mx-5">

                    <a href="#" class="text-light " style="text-decoration: none;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart3" viewBox="0 0 16 16">
                            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l.84 4.479 9.144-.459L13.89 4zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                        </svg> Cart <?php $query1 = mysqli_query($conn, "SELECT * FROM `customers` WHERE `userId` = '$_SESSION[userId]'");
                                    $row1 = mysqli_fetch_assoc($query1);
                                    $cartData = json_decode($row1['Cart'], true);
                                    echo $cartData['length']; ?></a>

                </div>


                <div class="form-inline my-2 my-lg-0 mx-2">

                    <a href="logout.php"><button class="btn btn-danger my-2 my-sm-0">Log Out</button></a>
                </div>
            </div>
        </div>
    </nav>


    <div id="succes-alert" class="alert alert-success alert-dismissible fade show container <?php if(!(isset($_GET['order']))){ echo 'd-none';}?>" role="alert">
        <strong><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-seam" viewBox="0 0 16 16">
                <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2zm3.564 1.426L5.596 5 8 5.961 14.154 3.5zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z" />
            </svg> Success!</strong> Thank you for choosing us!. We will call you for order confirmation.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <div class="container text-light mt-5">
        <h1 class="text-center m-5" style="margin-bottom: 30px;">Cart Details</h1>


        <div class="shopping-cart">

            <div class="column-labels">
                <label class="product-image">Image</label>
                <label class="product-details">Product</label>
                <label class="product-price">Flavour</label>
                <label class="product-price">Price</label>
                <label class="product-quantity">Quantity</label>
                <label class="product-removal">Remove</label>
                <label class="product-line-price">Total</label>
            </div>

            <?php

            foreach ($cartData['product'] as $index => $product) {
                $query2 = mysqli_query($conn, "SELECT * FROM `product` WHERE `sr` = '$product[productId]'");
                $row = mysqli_fetch_assoc($query2);
            ?>


                <div class="product">
                    <div class="product-image">
                        <img src="../<?php echo $row['imgUrl'] ?>">
                    </div>
                    <div class="product-details">
                        <div class="product-title"><?php echo $row['product'] ?></div>
                        <p class="product-description"><?php echo $row['description'] ?></p>
                    </div>
                    <div class="product-price1"><?php echo $product['flavour'] ?></div>
                    <div class="product-price"><?php echo $row['sellingPrice'] ?></div>
                    <div class="product-quantity ">
                        <input class="text-center item-quantity" data-price="<?php echo $row['sellingPrice'] ?>" data-flavour="<?php echo $product['flavour'] ?>" data-productid="<?php echo $product['productId'] ?>" style=" border-radius: 8px; border: none; height: 31px; width: 3rem;" type="number" value="1" min="1">
                    </div>
                    <div class="product-removal">
                        <button class="remove-product" data-sr="<?php echo $index; ?>">
                            Remove
                        </button>
                    </div>
                    <div class="product-line-price"><?php echo $row['sellingPrice'] ?></div>
                </div>

            <?php } ?>


            <div class="totals">
                <div class="totals-item">
                    <label>Subtotal</label>
                    <div class="totals-value" id="cart-subtotal">71.97</div>
                </div>

                <div class="totals-item">
                    <label>Shipping</label>
                    <div class="totals-value" id="cart-shipping">15.00</div>
                </div>
                <div class="totals-item totals-item-total">
                    <label>Grand Total</label>
                    <div class="totals-value" id="cart-total">90.57</div>
                </div>
            </div>

            <button class="checkout mb-5" data-bs-toggle="modal" data-bs-target="#exampleModal">Place Order</button>

        </div>


        <!-- Button trigger modal -->


        <!-- Modal -->
        <div class="modal fade " style="backdrop-filter: blur(8px); color:black;" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Enter Details</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="phoneNo" placeholder="Phone NO">
                            <label for="phoneNo">Phone No</label>
                        </div>
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Address" id="Address" style="height: 100px"></textarea>
                            <label for="Address">Address</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="placeOrder()">Confire Order</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        /* Set rates + misc */

        var shippingRate = 0;
        var fadeTime = 300;

        var total = 0;


        /* Assign actions */
        $('.product-quantity input').on('input', function() {
            updateQuantity(this);
        });

        $('.product-removal button').click(function() {
            removeItem(this);
        });

        recalculateCart();


        /* Recalculate cart */
        function recalculateCart() {
            var subtotal = 0;

            /* Sum up row totals */
            $('.product').each(function() {
                subtotal += parseFloat($(this).children('.product-line-price').text());
            });

            /* Calculate totals */

            var shipping = (subtotal > 0 ? shippingRate : 0);
             total = subtotal + shipping;

            /* Update totals display */
            $('.totals-value').fadeOut(fadeTime, function() {
                $('#cart-subtotal').html(subtotal.toFixed(0));
                // $('#cart-tax').html(tax.toFixed(0));
                $('#cart-shipping').html(shipping.toFixed(0));
                $('#cart-total').html(total.toFixed(0));
                if (total == 0) {
                    $('.checkout').fadeOut(fadeTime);
                } else {
                    $('.checkout').fadeIn(fadeTime);
                }
                $('.totals-value').fadeIn(fadeTime);
            });
        }


        /* Update quantity */
        function updateQuantity(quantityInput) {
            /* Calculate line price */
            var productRow = $(quantityInput).parent().parent();
            var price = parseFloat(productRow.children('.product-price').text());
            var quantity = $(quantityInput).val();
            var linePrice = price * quantity;

            /* Update line price display and recalc cart totals */
            productRow.children('.product-line-price').each(function() {
                $(this).fadeOut(fadeTime, function() {
                    $(this).text(linePrice.toFixed(0));
                    recalculateCart();
                    $(this).fadeIn(fadeTime);
                });
            });
        }


        /* Remove item from cart */
        function removeItem(removeButton) {

            let index = removeButton.dataset.sr;

            var dataToSend = {
                index
            };
            console.log(index);

            fetch('./backend/editCart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(dataToSend),
                }).then(response => response.text())
                .then(data => {
                    // Handle the response from the server, if needed
                    console.log(data);
                    if (data == "success") {
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });

        }

        function placeOrder() {
            const phoneNo = document.getElementById('phoneNo').value;
            const address = document.getElementById('Address').value;
        
            if (phoneNo < 5999999999 || phoneNo > 9999999999) {
                console.log('invalid', phoneNo);
                alert("Enter Vaild Phone No");
                return;
            }


            if (address.length < 5) {
                alert("Enter Address");
                return;
            }


            const input1 = document.querySelectorAll(".item-quantity");
            const quantityarray = [];
            for (let i = 0; i < input1.length; i++) {
                const quantity = input1[i].value;
                const price = input1[i].dataset.price;
                const flavour = input1[i].dataset.flavour;
                const productId = input1[i].dataset.productid;
                const obj = {
                    quantity,
                    flavour,
                    productId,
                    price
                }
                quantityarray.push(obj);
            }

            const dataToSend = {
                total,
                phoneNo,
                address,
                quantityarray
            }
  

            fetch('./backend/placeOrder.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(dataToSend),
                }).then(response => response.text())
                .then(data => {
                    // Handle the response from the server, if needed
                    console.log(data);
                    if (data == "success") {
                        window.location.href = "./cart.php?order=success";


                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });

        }
    </script>
</body>

</html>