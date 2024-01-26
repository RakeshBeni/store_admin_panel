<?php
include "./connection.php";
if (!isset($_GET['customer'])) {
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
        a {
            color: #69aaff;
            text-decoration: none;
        }

        a:hover {
            color: #83ac55;
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
                        <th scope="col">User Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Phone No</th>
                        <th scope="col">Address</th>
                        <th scope="col">Successfull Orders Details</th>
                        <th scope="col">Cancel Orders Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $index = 0;
                    $result = mysqli_query($conn, "SELECT * FROM customers WHERE `userId` = '$_GET[customer]' ");
                    while ($row = mysqli_fetch_assoc($result)) {
                        $index++;
                    ?>
                        <tr>

                            <td><?php echo $row['userId']; ?></td>
                            <td><?php echo $row['Name']; ?></td>
                            <td><?php echo $row['phoneNo']; ?></td>
                            <td><?php echo $row['address']; ?></td>


                            <td><!-- Button trigger modal -->
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $row['userId'] ?>">
                                    Successfull Orders
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal<?php echo $row['userId'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl" style="color:black">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Order Details</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                <table class="table table-striped border border-secondary text-center">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Order No</th>
                                                            <th scope="col">Status</th>
                                                            <th scope="col">Value</th>
                                                            <th scope="col">Items</th>
                                                            <th scope="col">feedback</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $result1 = mysqli_query($conn, "SELECT * FROM orders WHERE `FinalStatus` != 'cancel' OR `FinalStatus` IS NULL AND `customersId` = '$row[userId]'");
                                                        while ($row1 = mysqli_fetch_assoc($result1)) {

                                                        ?>

                                                            <tr>
                                                                <th scope="row"><a href="orderDetails.php?OrderId=<?php echo $row1['sr']; ?>"><?php echo $row1['sr']; ?></a> </th>


                                                                <td><?php if ($row1['FinalStatus']) {
                                                                        echo "<span class='text-success'>Successfull</span>";
                                                                    } elseif ($row1['trakingNo'] !== null) {
                                                                        echo "   <span class='text-success'>Order Dispatched</span>";
                                                                    } elseif ($row1['orderConfirmation'] == '1') {
                                                                        echo "   <span class='text-info'>Order Confirmed</span>";
                                                                    } else {
                                                                        echo "<span class='text-warning'>order Placed</span>";
                                                                    } ?></td>

                                                                <td><?php echo $row1['orderValue'] ?></td>

                                                                <td><?php $ordersArray = json_decode($row1['orders'], true);
                                                                    $objectCount = count($ordersArray);
                                                                    echo $objectCount; ?></td>
                                                                <td><?php if ($row1['FinalStatus'] !== null) {
                                                                        $query2 = mysqli_query($conn, "SELECT * FROM deliveredorder WHERE `OrderId` = '$row1[sr]'");
                                                                        $row2 = mysqli_fetch_assoc($query2);
                                                                        if ($row2['feedBack'] !== null) {
                                                                            echo $row2['feedBack'];
                                                                        }
                                                                    } ?></td>
                                                            </tr>

                                                        <?php } ?>


                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="modal-footer">

                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>

                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#example<?php echo $row['userId'] ?>">
                                    Cancel Orders
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="example<?php echo $row['userId'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl" style="color:black">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Order Details</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                <div class="m-5">
                                                    <table class="table table-striped border border-secondary text-center">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Order No</th>
                                                                <th scope="col">Payment</th>
                                                                <th scope="col">Value</th>
                                                                <th scope="col">Items</th>
                                                                <th scope="col">Remarks</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $result11 = mysqli_query($conn, "SELECT * FROM orders WHERE `FinalStatus` = 'cancel' AND `customersId` = '$row[userId]'");

                                                            while ($row11 = mysqli_fetch_assoc($result11)) {
                                                            ?>

                                                                <tr>
                                                                   
                                                                    <th scope="row"><a href="orderDetails.php?OrderId=<?php echo $row11['sr']; ?>"><?php echo $row11['sr']; ?></a></th>
                                                                    <td><?php if ($row11['payment'] == 1) {
                                                                            echo " <span class='text-success'>Received</span>";
                                                                        } else {
                                                                            echo "<span class='text-danger'>Unpaid</span>";
                                                                        } ?></td>
                                                                    <td><?php echo $row11['orderValue'] ?></td>

                                                                    <td><?php $ordersArray = json_decode($row11['orders'], true);
                                                                        $objectCount = count($ordersArray);
                                                                        echo $objectCount; ?></td>
                                                                    <td><?php if ($row11['FinalStatus'] !== null) {
                                                                            $query2 = mysqli_query($conn, "SELECT * FROM cancelorders WHERE `OrderId` = '$row11[sr]'");
                                                                            $row2 = mysqli_fetch_assoc($query2);
                                                                            if ($row2['Remarks'] !== null) {
                                                                                echo $row2['Remarks'];
                                                                            }
                                                                        } ?></td>
                                                                </tr>

                                                            <?php } ?>


                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="modal-footer">

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
    <script>

    </script>

</body>


</html>