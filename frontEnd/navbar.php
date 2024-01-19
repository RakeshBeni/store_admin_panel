<nav class="navbar bg-dark border-bottom border-body navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="btn btn-secondary mx-2" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                    Products
                </button>
                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                   <?php  $sqlresult = mysqli_query($conn, "SELECT DISTINCT `category` FROM `product` ");
                   while($row00 = mysqli_fetch_assoc($sqlresult)){
                    echo '<li><a class="dropdown-item" href="index.php?category='.$row00['category'].'">'.$row00['category'].'</a></li>';
                   }
                   ?>
                    
                    
                  
                    
                </ul>
            </div>
                </li>
                <li class="nav-item">
                    <a class="btn btn-secondary mx-2" aria-current="page" href="./orders.php">Orders <?php echo mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS total_complaints FROM `orders` WHERE `customersId` = '$_SESSION[userId]'"))['total_complaints'];
                                                                                                ?></a></a>
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