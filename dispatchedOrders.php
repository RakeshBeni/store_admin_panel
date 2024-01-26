<?php
include "./connection.php";

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
            <div class="btn-group"><button type="button" class="btn btn-secondary btn-lg shadow" disabled><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bus-front" viewBox="0 0 16 16">
                        <path d="M5 11a1 1 0 1 1-2 0 1 1 0 0 1 2 0m8 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m-6-1a1 1 0 1 0 0 2h2a1 1 0 1 0 0-2zm1-6c-1.876 0-3.426.109-4.552.226A.5.5 0 0 0 3 4.723v3.554a.5.5 0 0 0 .448.497C4.574 8.891 6.124 9 8 9s3.426-.109 4.552-.226A.5.5 0 0 0 13 8.277V4.723a.5.5 0 0 0-.448-.497A44 44 0 0 0 8 4m0-1c-1.837 0-3.353.107-4.448.22a.5.5 0 1 1-.104-.994A44 44 0 0 1 8 2c1.876 0 3.426.109 4.552.226a.5.5 0 1 1-.104.994A43 43 0 0 0 8 3" />
                        <path d="M15 8a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1V2.64c0-1.188-.845-2.232-2.064-2.372A44 44 0 0 0 8 0C5.9 0 4.208.136 3.064.268 1.845.408 1 1.452 1 2.64V4a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1v3.5c0 .818.393 1.544 1 2v2a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5V14h6v1.5a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5v-2c.607-.456 1-1.182 1-2zM8 1c2.056 0 3.71.134 4.822.261.676.078 1.178.66 1.178 1.379v8.86a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 11.5V2.64c0-.72.502-1.301 1.178-1.379A43 43 0 0 1 8 1" />
                    </svg> &nbsp Dispatched Order</button>


            </div>
        </center>
        <div class="mt-5">

            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th scope="col">Sr</th>
                        <th scope="col">Time</th>
                        <th scope="col">Name</th>
                        <th scope="col">Phone No</th>
                        <th scope="col">Address</th>
                        <th scope="col">Order Value</th>
                        <th scope="col">Description</th>
                        <th scope="col">Products</th>
                        <th scope="col">Processing</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $index = 0;
                    $result = mysqli_query($conn, "SELECT * FROM orders  WHERE `orderConfirmation` = '1' AND `trakingNo` IS NOT NULL AND `FinalStatus` IS NULL
                     ORDER BY sr DESC;");
                    while ($row = mysqli_fetch_assoc($result)) {
                        $index++;
                    ?>
                        <tr>
                            <th scope="row"><?php echo $index; ?></th>
                            <td><?php echo $row['timestamp']; ?></td>
                            <td><?php $result1 = mysqli_query($conn, "SELECT `Name` FROM `customers` WHERE `userId` = '$row[customersId]'");
                                $row1 = mysqli_fetch_assoc($result1);
                                echo $row1['Name']; ?></td>
                            <td><?php echo $row['phoneNo']; ?></td>
                            <td><?php echo $row['address']; ?></td>
                            <td><?php echo $row['orderValue']; ?></td>
                            <td><?php echo $row['confirmationDescription'] ?></td>
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
                                                <h3 class="text-success">Track Id : <?php echo $row['trakingNo'] ?></h3>
                                                <p>Description: <?php echo $row['dispatchDescription'] ?></p>
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
                                                }else{
                                                    echo ' <button type="button" class="btn  btn-primary"  data-bs-toggle="modal" data-bs-target="#paymentRecived" data-bs-sr="'.$row['sr'].'">Payment Received</button>';
                                                } ?>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>

                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#processing" data-bs-sr="<?php echo $row['sr'] ?>"> Process</button>
                            </td>
                        </tr>

                    <?php } ?>

                </tbody>
            </table>

        </div>


    </div>



    <div class="modal fade" id="paymentRecived" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="color:black">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="./Backend/paymentRec.php" method="post" enctype="multipart/form-data">
                        <input type="text" name="Dispatch" value="" hidden>
                        <input type="text" id="srValue" name="orderId" value="" hidden>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">ScreenShort</label>
                            <input type="file" name="paymentImage" accept="image/*" class="form-control" id="recipient-name">
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="Submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="paymentImage" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " style="color:black">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="paymentImage1" width="100%" src="" alt="payment Image">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <!-- <button type="Submit" class="btn btn-primary">Submit</button> -->

                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="processing" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="color:black">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="./Backend/delivered.php" method="post" >

                        <input type="text" id="srValue11" name="orderId" value="" hidden>
                        <div class="btn-group col-12 mb-3" role="group" aria-label="Basic radio toggle button group">
                            <input type="radio" class="btn-check" name="Status" value="delivered" id="btnradio1" autocomplete="off" checked>
                            <label class="btn btn-outline-success btn-lg" for="btnradio1">Delivered</label>

                            <input type="radio" class="btn-check" name="Status" value="cancel" id="btnradio2" autocomplete="off">
                            <label class="btn btn-outline-danger btn-lg" for="btnradio2">Cancel</label>
                        </div>

                        <div class="form-floating">
                            <textarea class="form-control" name="description" placeholder="Leave a comment here" id="floatingText" style="height: 100px"></textarea>
                            <label for="floatingText">Description</label>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="Submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>





    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>

          
var exampleModal = document.getElementById('paymentRecived')
        exampleModal.addEventListener('show.bs.modal', function(event) {
            // Button that triggered the modal
            var button = event.relatedTarget
            // Extract info from data-bs-* attributes
            var recipient = button.getAttribute('data-bs-sr')

            const srvalue = document.getElementById('srValue');
            srvalue.setAttribute("value", recipient);

        })


        var exampleModal = document.getElementById('paymentImage')
        exampleModal.addEventListener('show.bs.modal', function(event) {
            // Button that triggered the modal
            var button = event.relatedTarget
            // Extract info from data-bs-* attributes
            var recipient = button.getAttribute('data-bs-image')

            const srvalue = document.getElementById('paymentImage1');
            srvalue.setAttribute("src", recipient);

        })
        var exampleModal = document.getElementById('processing')
        exampleModal.addEventListener('show.bs.modal', function(event) {
            // Button that triggered the modal
            var button = event.relatedTarget
            // Extract info from data-bs-* attributes
            var recipient = button.getAttribute('data-bs-sr')
            console.log(recipient)

            const srvalue = document.getElementById('srValue11');
            console.log(srvalue)
            srvalue.setAttribute("value", recipient);

        })
    </script>

</body>


</html>