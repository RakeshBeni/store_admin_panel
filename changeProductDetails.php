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

    <style>
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
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">

        <h3 class="text-center text-light mb-3">Edit Products Details</h3>

        <div class=" d-flex  justify-content-center">
            <div class="">
            <form action="./Backend/updatePhoto.php" method="post" enctype="multipart/form-data">
                <input type="text" name="sr" value="<?php echo $_GET['sr']?>" hidden>

                <div class="d-flex input-group mb-3 custom-file-button col-6 ">
                    <span class="input-group-text" id="basic-addon3">Product Image</span>
                    <input type="file" class="form-control bg-dark text-white col-6" placeholder="Invoice image" accept="image/png" name="productPhoto" aria-describedby="basic-addon3" onchange="previewImage(event)" required>
                </div>
                <div class="text-center">
                    
                    <button type="submit" class="btn btn-success mb-3" > Upload Image</button>
                </div>
            </form>
            </div>
        </div>

        <div class="row d-flex justify-content-around">
            <?php
            $result = mysqli_query($conn, "SELECT * FROM `product` WHERE `sr` = '$_GET[sr]'");
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <div class="card bg-dark text-light border-light mb-3" style="width: 22rem;">
                    <img src="<?php echo $row['imgUrl'] ?>" id="productImg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title" id="tital" contenteditable="true"><?php echo $row['product'] ?></h5>
                        <p class="card-text" id="cart-description" contenteditable="true"><?php echo $row['description'] ?>.</p>
                        <p class="card-text"><span class="text-light h3"> &#8377 <span id="sellingPrice" contenteditable="true"><?php echo $row['sellingPrice'] ?></span>/-</span> MRP: <del id="mrp" contenteditable="true"><?php echo $row['mrp'] ?></del>/- <span class="text-success">(<?php $discount = (($row['mrp'] - $row['sellingPrice']) / $row['mrp']) * 100;
                                                                                                                                                                                                                                                                                            echo round($discount) ?>% off)</span></p>

                        <button class="btn btn-primary" onclick="SaveData()">Save Details</button>

                    </div>
                </div>
            <?php } ?>



        </div>
    </div>








    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('productImg');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }


        function SaveData() {
            const tital = document.getElementById('tital').innerText;
            const cartDescription = document.getElementById('cart-description').innerText;
            let sellingPrice = document.getElementById('sellingPrice').innerText;
            let mrp = document.getElementById('mrp').innerText;

            let number_mrp = Number(mrp);

            if (isNaN(number_mrp)) {
                alert(mrp + " is not a Number")
                return
            }

            let number_sellingPrice = Number(sellingPrice);
            if (isNaN(number_sellingPrice)) {
                alert(sellingPrice + " is not a Number");
                return
            }
            let sr = <?php echo $_GET['sr'] ?>



            const dataToSend = {
                sr,
                tital,
                cartDescription,
                sellingPrice,
                sellingPrice,
                mrp

            }
            console.log(dataToSend);

            fetch('./Backend/editProductDetails.php', {
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