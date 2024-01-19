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
            height: 38rem;
        }

        .imagecss {
            object-fit: contain;
            height: 40%;


        }
    </style>
</head>

<body class="bg-dark">
<?php include './navbar.php'?>

    <div class="container mt-4">

    <center>
            <div class="btn-group"><button type="button" class="btn btn-secondary btn-lg shadow mb-4" disabled><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-seam" viewBox="0 0 16 16">
                                <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2zm3.564 1.426L5.596 5 8 5.961 14.154 3.5zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z" />
                            </svg> &nbsp <?php    if(isset($_GET['category'])){echo $_GET['category'];}else{echo "All Products";}?> </button>


            </div>
        </center>

        <!-- <h3 class="text-center text-light mb-3"></h3> -->

        <div class="row d-flex justify-content-around">
            <?php
            if(isset($_GET['category'])){
                $result = mysqli_query($conn, "SELECT * FROM `product` WHERE `isvisible` = '1' AND `category` = '$_GET[category]'");
            }else{
                $result = mysqli_query($conn, "SELECT * FROM `product` WHERE `isvisible` = '1'");
            }
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

            if(flavours.length<1){
                alert('Select Flavour');
                return;
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