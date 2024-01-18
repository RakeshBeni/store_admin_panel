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
            <div class="btn-group"><button type="button" class="btn btn-secondary btn-lg shadow" disabled><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
                        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0" />
                        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z" />
                    </svg> &nbsp Successfull Order</button>


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
                        <th scope="col">Products</th>
                        <th scope="col">Processing</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $index = 0;
                    $result = mysqli_query($conn, "SELECT * FROM orders  WHERE `orderConfirmation` = '1' AND `trakingNo` IS NOT NULL AND `FinalStatus` = 'cancel'
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
                                                } else {
                                                    echo ' <button type="button" class="btn  btn-primary"  data-bs-toggle="modal" data-bs-target="#paymentRecived" data-bs-sr="' . $row['sr'] . '">Payment Received</button>';
                                                } ?>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>

                                <?php $result3 = mysqli_query($conn, "SELECT * FROM `cancelorders` WHERE `OrderId` = '$row[sr]'");
                                $row3 = mysqli_fetch_assoc($result3);

                                if ($row3['Remarks'] == null) {

                                    echo "<button class='btn btn-outline-primary btn-sm ' data-bs-toggle='modal' data-bs-target='#processing'  data-bs-feedback=' " . $row['finalDescription'] . "' data-bs-sr=' " . $row['sr'] . "'> Add Remarks</button>";
                                } else {

                                    echo "<button class='btn btn-primary btn-sm ' data-bs-toggle='modal' data-bs-target='#feedback' data-bs-feedback1=' " . $row['finalDescription'] . "' data-bs-feedback=' " . $row3['Remarks'] . "'>View Remarks </button>";
                                }


                                ?>
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


                    <h5>Remarks On cancellation</h5>
                    <p id="feedbackText1"></p>
                    <hr>
                    <form action="./Backend/cancelOrderProcess.php" method="post">
                        <input type="text" id="srValue11" name="OrderNo" value="" hidden>

                        <div class="form-floating">

                            <textarea class="form-control" name="description" placeholder="Leave a comment here" id="floatingText" style="height: 100px"></textarea>
                            <label for="floatingText">Add Remarks</label>
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

    <div class="modal fade" id="feedback" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="color:black">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Remarks</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5>Final Remarks</h5>
                    <p id="feedbackText"></p>
                    <hr>
                    <h5>Remarks On cancellation</h5>
                    <p id="feedbackText2"></p>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>





    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        var exampleModal = document.getElementById('feedback')
        exampleModal.addEventListener('show.bs.modal', function(event) {

            var button = event.relatedTarget

            var recipient = button.getAttribute('data-bs-feedback')

            document.getElementById('feedbackText').innerText = recipient;

            var recipient = button.getAttribute('data-bs-feedback1')

            document.getElementById('feedbackText2').innerText = recipient


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
            var remarks = button.getAttribute('data-bs-feedback')
            console.log(recipient)

            document.getElementById('feedbackText1').innerText = remarks;

            const srvalue = document.getElementById('srValue11');
            console.log(srvalue)
            srvalue.setAttribute("value", recipient);



        })
    </script>

</body>


</html>