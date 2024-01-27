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


    <div id="succes-alert" class="alert alert-success alert-dismissible fade show container <?php if (!(isset($_GET['order']))) {
                                                                                                echo 'd-none';
                                                                                            } ?>" role="alert">
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
                        <div class="product-title  h5"><?php echo $row['product'] ?></div>
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
            <div class="d-flex">


                <div class="col-md-6 col-12 ">
                    <div class="form-floating mb-3 text-dark" id="couponfild">
                        <input type="email" class="form-control " id="couponInput" placeholder="name@example.com">
                        <label for="floatingInput ">Enter Coupon</label>

                        <div id="validationServerUsernameFeedback" class="invalid-feedback">
                            InValid Coupon.
                        </div>
                    </div>
                </div>


                <div class="totals col-md-6 col-12">
                    <div class="totals-item">
                        <label>Subtotal</label>
                        <div class="totals-value" id="cart-subtotal">00.00</div>
                    </div>

                    <div class="totals-item">
                        <label>Coupon Discount</label>
                        <div class="totals-value " style="    color: #49c249;" id="cart-tax">0</div>
                    </div>

                    <div class="totals-item">
                        <label>Shipping</label>
                        <div class="totals-value" id="cart-shipping">00.00</div>
                    </div>
                    <div class="totals-item totals-item-total">
                        <label>Grand Total</label>
                        <div class="totals-value" id="cart-total">00.00</div>
                    </div>
                </div>

            </div>
            <button class="checkout mb-5" data-bs-toggle="modal" data-bs-target="#exampleModal">Place Order</button>

        </div>


        <!-- Button trigger modal -->


        <!-- Modal -->
        <div class="modal fade " style="backdrop-filter: blur(8px); color:black;" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Enter Details</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" value="<?php echo $row1['phoneNo'] ?>" id="phoneNo" placeholder="Phone NO">
                            <label for="phoneNo">Phone No</label>
                        </div>
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Address" id="Address" style="height: 100px"> <?php echo $row1['address'] ?></textarea>
                            <label for="Address">Address</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="confirmNO" class="btn btn-primary <?php if ($row1['verifiedPhoneNo'] === '1') { echo "d-none"; } ?>" onclick="confirmPhoneNo()">Confire Phone No</button>
                        <button type="button" class="btn btn-primary <?php if ($row1['verifiedPhoneNo'] === '0') {  echo "d-none";  } ?>" onclick="placeOrder()">Confire Order</button>
                        <button type="button" id="otpWait" class="btn btn-primary disabled d-none">Wait for OTP</button>
                        <button type="button" class="btn btn-primary d-none" data-bs-toggle="modal" id="showOtpModal" data-bs-target="#OTPmodal">Enter OTP</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade " data-bs-backdrop="static" style="backdrop-filter: blur(8px); color:black;" id="OTPmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Enter Details</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="OTP" placeholder="Phone NO">
                            <label for="phoneNo">Enter OTP</label>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="confirmOTP()">Confire Phone No</button>
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
        var discount = 0;

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
            total = subtotal + shipping - discount;

            /* Update totals display */
            $('.totals-value').fadeOut(fadeTime, function() {
                $('#cart-subtotal').html(subtotal.toFixed(0));
                $('#cart-tax').html(discount.toFixed(0));
                $('#cart-shipping').html(shipping.toFixed(0));
                $('#cart-total').html(total.toFixed(0));
                if (total == 0) {
                    $('.checkout').fadeOut(fadeTime);
                    $('#couponfild').fadeOut(fadeTime);
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

        function confirmPhoneNo() {
            document.getElementById('confirmNO').classList.add('d-none');
            document.getElementById('otpWait').classList.remove('d-none');
            const phoneNo = document.getElementById('phoneNo').value;

            if (phoneNo < 5999999999 || phoneNo > 9999999999) {
                console.log('invalid', phoneNo);
                alert("Enter Vaild Phone No");
                return;
            }

            const apiUrl = './backend/veryfyPhoneNo.php?phoneNO=' + phoneNo;
            console.log(apiUrl);

            fetch(apiUrl)
                .then(response => {
                    // Check if the request was successful (status code 200-299)
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.text();
                })
                .then(data => {
                    console.log(data);
                    if (data === "successfull") {
                        $('#OTPmodal').modal("show")
                        document.getElementById("showOtpModal").classList.remove("d-none");
                        document.getElementById("otpWait").classList.add("d-none");
                        
                    }else{
                        document.getElementById("confirmNO").classList.remove("d-none");
                        document.getElementById("otpWait").classList.add("d-none");
                        alert('There is some issue. Please Try After some time');
                    }
                })
                .catch(error => {
                    // Handle errors
                    console.error('Fetch error:', error);
                });


        }

        async function placeOrder() {
            const phoneNo = document.getElementById('phoneNo').value;
            const address = document.getElementById('Address').value;
            const coupon = document.getElementById('couponInput').value;


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
                quantityarray,
                discount,
                coupon
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

        function applycoupon(coupon) {
            const couponinput = document.getElementById('couponInput');

            const data = {
                coupon
            };
            console.log(data)
            fetch('./backend/applycoupon.php', {
                    method: 'POST',
                    body: JSON.stringify(data),
                }).then(res => res.json())
                .then(data => {
                    if (data.status === "Success") {
                        couponinput.classList.remove('is-invalid');
                        couponinput.classList.add('is-valid');
                        discount = parseInt(data.discount);
                        recalculateCart();
                    } else if (data.status === "Invalid") {
                        couponinput.classList.remove('is-valid');
                        couponinput.classList.add('is-invalid');
                        console.log("invalid")
                        discount = 0;
                        recalculateCart();
                    }
                    console.log(data)
                })
        }

        function debounce(func, delay) {
            let timeoutId;
            return function() {
                const context = this;
                const args = arguments;
                clearTimeout(timeoutId);
                timeoutId = setTimeout(function() {
                    func.apply(context, args);
                }, delay);
            };

        }

        function handleInput() {
            const inputValue = document.getElementById('couponInput').value;
            applycoupon(inputValue)
            // Perform the desired action with the debounced value
        }
        const debouncedInputHandler = debounce(handleInput, 800);
        document.getElementById('couponInput').addEventListener("input", debouncedInputHandler)


        function confirmOTP() {
            const otp = document.getElementById('OTP').value;
            fetch(`./backend/confirmOtp.php?otp=${otp}`, {
                    method: 'GET'
                }).then(res => res.text())
                .then(data => {
                    console.log(data)
                    if(data === "verified"){
                        console.log('hii');
                        placeOrder();
                    }else if(data === "otp expire"){
                        alert("otp expired Please try again")
                    }else if(data === "otp invalid"){
                        alert('invalid Opt')
                    }
                })
        }
    </script>
</body>

</html>