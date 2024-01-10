<?php
include "./connection.php";


session_start();

if (!isset($_SESSION['user'])) {
    header('location:login.php');
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

        .cardcss {
            width: 24rem;
            height: 35rem;
        }

        .imagecss {
            object-fit: contain;
            height: 50%;


        }
    </style>
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
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>

                </ul>
                <div class="mx-5">

                    <a href="./cart.php" class="text-light " style="text-decoration: none;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart3" viewBox="0 0 16 16">
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

    <div class="container mt-4">

        <h3 class="text-center text-light mb-3">All Products</h3>

        <div class="row d-flex justify-content-around">
            <?php
            $result = mysqli_query($conn, "SELECT * FROM `product` WHERE `isvisible` = '1'");
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <div class="card bg-dark text-light border-light mb-3 cardcss">
                    <img src="../<?php echo $row['imgUrl'] ?>" class="card-img-top imagecss" alt="...">
                    <div class="card-body" style=" overflow: overlay;">
                        <h5 class="card-title"><?php echo $row['product'] ?> <span><?php echo $row['weight']; ?></span></h5>
                        <p class="card-text"><?php echo $row['description'] ?></p>


                        <div class="btn-group d-flex flex-wrap" role="group" aria-label="Basic checkbox toggle button group">



                            <?php $jsonData = json_decode($row['flavour'], true);
                            foreach ($jsonData as $key => $value) {
                                foreach ($value as $value) {
                            ?>
                                    <input type="checkbox" value="<?php echo $value; ?>" class="btn-check" id="<?php echo $value . $row['sr']; ?>" autocomplete="off">
                                    <label class="btn btn-outline-secondary my-1" for="<?php echo $value . $row['sr']; ?>"><?php echo $value; ?></label>
                            <?php  }
                            }   ?>
                        </div>
                        <p class="card-text"><span class="text-light h3"> &#8377 <?php echo $row['sellingPrice'] ?>/-</span> MRP: <del><?php echo $row['mrp'] ?></del>/- <span class="text-success">(<?php $discount = (($row['mrp'] - $row['sellingPrice']) / $row['mrp']) * 100;
                                                                                                                                                                                                        echo round($discount) ?>% off)</span></p>
                        <div>
                            <?php
                            if ($row['instock'] == '1') {
                                echo " <button class='btn btn-primary' onclick='addcart(this)' data-product=' $row[sr]'>Add to cart</button>";
                            } else {
                                echo " <button class='btn btn-primary disabled' >Out Of Stock</button>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php } ?>



        </div>
    </div>









    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        function addcart(e) {
            const productId = e.dataset.product;

            let btnCheckElements = e.parentNode.parentNode.getElementsByClassName('btn-check');
            let flavours = [];
            for (var i = 0; i < btnCheckElements.length; i++) {
                let checkbox = btnCheckElements[i]
                if (checkbox.checked) {
                    flavours.push(checkbox.value)
                } 
            }

            
            
            const dataToSend = {
                productId,
                flavours
            }
        
            
            fetch('./Backend/addtoCart.php', {
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
    </script>
</body>


</html>