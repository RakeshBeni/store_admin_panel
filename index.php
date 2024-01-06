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
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>

        </ul>
        <form class="d-flex" role="search" id="searchForm">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>

  <div class="container mt-4">

    <h3 class="text-center text-light mb-3">All Products</h3>

    <div class="row d-flex justify-content-around">
      <?php
      $result = mysqli_query($conn, "SELECT * FROM `product`");
      while ($row = mysqli_fetch_assoc($result)) {
      ?>
        <div class="card bg-dark text-light border-light mb-3 cardcss">
          <img src="<?php echo $row['imgUrl'] ?>" class="card-img-top imagecss" alt="...">
          <div class="card-body">
            <h5 class="card-title"><?php echo $row['product'] ?> <span><?php echo $row['weight']; ?></span></h5>
            <p class="card-text"><?php echo $row['description'] ?></p>
            <p class="card-text"><span class="text-light h3"> &#8377 <?php echo $row['sellingPrice'] ?>/-</span> MRP: <del><?php echo $row['mrp'] ?></del>/- <span class="text-success">(<?php $discount = (($row['mrp'] - $row['sellingPrice']) / $row['mrp']) * 100;
                                                                                                                                                                                          echo round($discount) ?>% off)</span></p>
            <a href="./changeProductDetails.php?sr=<?php echo $row['sr']; ?>"><button class="btn btn-primary m-1">Edit Details</button></a>
            <button class="btn <?php if ($row['instock']) {
                                  echo 'btn-success';
                                } else {
                                  echo ' btn-danger';
                                } ?> m-1" data-type="Stock" data-status="<?php echo $row['instock'] ?>" data-sr="<?php echo $row['sr']; ?>" onclick="changeStock(this)">Stock</button>
            <button class="btn <?php if ($row['isvisible']) {
                                  echo 'btn-success';
                                } else {
                                  echo ' btn-danger';
                                } ?> m-1" data-type="visible" data-status="<?php echo $row['isvisible'] ?>" data-sr="<?php echo $row['sr']; ?>" onclick="changeStock(this)">visibity</button>
          </div>
        </div>
      <?php } ?>

      <div class="card bg-dark text-light border-light mb-3" onclick="addProduct()" style="width: 22rem;">

        <div class="card-body d-flex align-items-center justify-content-center ">
          <h1 class="text-center text-success m-0 " style="font-size: 200px;">+</h1>

        </div>
      </div>

    </div>
  </div>




  <div class="modal fade" style=" backdrop-filter: blur(8px);" id="addProductModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content bg-dark">

        <p class="h3 text-light m-4 text-center"> Add product</p>

        <div class="modal-body text-light">
          <form id="myForm" action="./Backend/addproduct.php" method="post" enctype="multipart/form-data">


            <div class="input-group mb-3 custom-file-button">
              <span class="input-group-text" id="basic-addon3">Product Image</span>
              <input type="file" class="form-control bg-dark text-white" placeholder="Invoice image" accept="image/png" name="productPhoto" aria-describedby="basic-addon3" required>
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text" id="basic-addon1">category</span>
              <!-- <input type="text" class="form-control bg-dark text-white" > -->
              <select class="form-select bg-dark text-white" aria-label="Default select example" value="" name="category" required>
                <option value="" selected hidden>Select Category</option>
                <?php $result1 = mysqli_query($conn, "SELECT * FROM `category`");
                while ($row1 = mysqli_fetch_assoc($result1)) { ?>
                  <option value="<?php echo $row1['category'] ?>"><?php echo $row1['category'] ?></option>

                <?php } ?>
              </select>
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text" id="basic-addon1">Product</span>
              <input type="text" class="form-control bg-dark text-white" name="product">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text" id="basic-addon1">Weight</span>
              <input type="text" class="form-control bg-dark text-white" name="weight">
            </div>

            <div class=" mb-3 bg-dark">
              <select class="form-control multiple-select bg-dark" multiple>
                <?php
                $con = new mysqli('89.117.157.168', 'u359658933_authenfitplus', 'G00dL1fe$$$$', 'u359658933_authenfitplus');
                $result = mysqli_query($con, "SELECT * FROM `category and flavours`");
                while ($row2 = mysqli_fetch_assoc($result)) {  ?>
                  <option class="<?php echo $row2['flavour'] ?>" value="<?php echo $row2['flavour'] ?>"><?php echo $row2['flavour'] ?></option>
                <?php } ?>

              </select>
            </div>



            <div class="input-group mb-3">
              <span class="input-group-text" id="basic-addon1">MRP</span>
              <input type="number" class="form-control bg-dark text-white" name="mrp">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text" id="basic-addon1">Selling Price</span>
              <input type="number" class="form-control bg-dark text-white" name="sellingPrice">
            </div>


            <div class="input-group mb-3">
              <span class="input-group-text">Description</span>
              <textarea rows="3" class="form-control bg-dark text-white" name="description"></textarea>
            </div>

        </div>
        <div class="d-flex justify-content-end">
          <button type="button" class="btn btn-secondary m-2" data-bs-dismiss="modal">Close</button>
          <button type="button" onclick="submitForm()" class="btn btn-primary m-2">Save changes</button>

        </div>
        </form>
      </div>
    </div>
  </div>




  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  <script>
    function changeStock(a) {
      const productSr = a.getAttribute('data-sr');
      const productStatus = a.getAttribute('data-status');
      const type = a.getAttribute('data-type');

      const dataToSend = {
        type,
        productSr,
        productStatus
      }

      fetch('./Backend/editProductStatus.php', {
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



    function addProduct() {
      $('#addProductModal').modal('show')
    }

 
  </script>
  <script src="index.js"></script>
</body>


</html>