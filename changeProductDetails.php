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

            </div>
        </div>
    </nav>

    <div class="container mt-4">

        <h3 class="text-center text-light mb-3">Edit Products Details</h3>

        <div class=" d-flex  justify-content-center">
            <div class="">
                <form action="./Backend/updatePhoto.php" method="post" enctype="multipart/form-data">
                    <input type="text" name="sr" value="<?php echo $_GET['sr'] ?>" hidden>

                    <div class="d-flex input-group mb-3 custom-file-button col-6 ">
                        <span class="input-group-text" id="basic-addon3">Product Image</span>
                        <input type="file" class="form-control bg-dark text-white col-6" placeholder="Invoice image" accept="image/png" name="productPhoto" aria-describedby="basic-addon3" onchange="previewImage(event)" required>
                    </div>
                    <div class="text-center">

                        <button type="submit" class="btn btn-success mb-3"> Upload Image</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row d-flex justify-content-around bg-dark">
            <?php
            $result = mysqli_query($conn, "SELECT * FROM `product` WHERE `sr` = '$_GET[sr]'");
            $row = mysqli_fetch_assoc($result)
            ?>
            <div class="card bg-dark text-light border-light mb-3" style="width: 24rem; height: 35rem">
                <img src="<?php echo $row['imgUrl'] ?>" id="productImg" class="card-img-top" style="  object-fit: contain;
  height: 50%;" alt="...">
                <div class="card-body" style=" overflow: overlay;">
                    <h5 class="card-title"><span id="tital" contenteditable="true"> <?php echo $row['product'] ?> </span>  <span id="weight" contenteditable="true"><?php echo $row['weight']; ?></span></h5>
                    <p class="card-text" id="cart-description" contenteditable="true"><?php echo $row['description'] ?></p>
                    <p class="card-text"><span class="text-light h3"> &#8377 <span id="sellingPrice" contenteditable="true"><?php echo $row['sellingPrice'] ?></span>/-</span> MRP: <del id="mrp" contenteditable="true"><?php echo $row['mrp'] ?></del>/- <span class="text-success">(<?php $discount = (($row['mrp'] - $row['sellingPrice']) / $row['mrp']) * 100;
                                                                                                                                                                                                                                                                                        echo round($discount) ?>% off)</span></p>
                    <div class=" mb-3">
                        <select class="form-control multiple-select bg-dark " multiple>
                            <?php
                            $con = new mysqli('89.117.157.168', 'u359658933_authenfitplus', 'G00dL1fe$$$$', 'u359658933_authenfitplus');
                            $result = mysqli_query($con, "SELECT * FROM `category and flavours`");
                            while ($row2 = mysqli_fetch_assoc($result)) {  ?>
                                <option class="<?php echo $row2['flavour'] ?>" value="<?php echo $row2['flavour'] ?>"><?php echo $row2['flavour'] ?></option>
                            <?php } ?>

                        </select>
                    </div>
                    <button class="btn btn-primary" onclick="SaveData()">Save Details</button>

                </div>
            </div>




        </div>
    </div>








    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        const obj = <?php print_r($row['flavour']) ?>;
        const arrobj = obj?.flavour || [];

        $(function() {
            $(".multiple-select").each(function() {



                $(this).hide();

                var optionsArray = [],
                    selectClasses = $(this).attr("class");

                $(this)
                    .find("option")
                    .each(function() {
                        var optionObject = {};
                        optionObject.text = $(this).text();
                        optionObject.value = $(this).val();
                        optionObject.class = $(this).attr("class");

                        optionsArray.push(optionObject);

                    });


                var multipleSelectHtml =
                    "<div class='multiple-select-container " +
                    selectClasses +
                    "'>" +
                    "<ul class='multiple-select-choices' id='ulidd'><li class='input bg-dark'><input class='bg-dark' type='text' placeholder='Please select'></li></ul>" +
                    "<div class='multiple-select-dropdown'><ul>";


                let alreadyPresent = "";

                for (var i = 0; i < optionsArray.length; i++) {

                    if (arrobj.includes(optionsArray[i].value)) {

                        multipleSelectHtml +=
                            "<li class='" +
                            optionsArray[i].class +
                            " option-disabled' data-value='" +
                            optionsArray[i].value +
                            "'>" +
                            optionsArray[i].text +
                            "</li>";

                        alreadyPresent += "<li data-value='" + optionsArray[i].value + "'  class='choice-active'>" + optionsArray[i].text + " <a href='#' class='remove-item'>&times;</a></li>";


                    } else {
                        // Regular option
                        multipleSelectHtml +=
                            "<li class='" +
                            optionsArray[i].class +
                            "' data-value='" +
                            optionsArray[i].value +
                            "'>" +
                            optionsArray[i].text +
                            "</li>";
                    }
                }




                multipleSelectHtml += "</ul></div></div>";

                if(arrobj.length>0){
                    alreadyPresent += `<li class='input bg-dark choice-active'><input class='bg-dark' type='text' placeholder=''></li>`;
                }else{
                    alreadyPresent += `<li class='input bg-dark'><input class='bg-dark' type='text' placeholder='Please select'></li>`;

                }

                $(multipleSelectHtml).insertAfter($(this));


                var choicesContainer = document.getElementById('ulidd');

                choicesContainer.innerHTML = alreadyPresent;




            });

            // Show dropdown when input is focused
            $(".multiple-select-container").on("click", function() {
                $(this).find(".multiple-select-dropdown").show();
            });

            // Close dropdown when multi-select is out of focus
            $(document).on("click", function(e) {
                var $tgt = $(e.target);

                if (
                    !$tgt.is(".multiple-select-dropdown li") &&
                    !$tgt.is(".multiple-select-container input") &&
                    !$tgt.is(".multiple-select-container") &&
                    !$tgt.is(".multiple-select-choices")
                ) {
                    $(".multiple-select-dropdown").hide();
                }
            });

            // Add item
            $(document).on(
                "click",
                ".multiple-select-dropdown li:not(.option-disabled)",
                function(e) {

                    e.preventDefault();

                    var optionText = $(this).text(),
                        optionValue = $(this).data("value"),
                        optionClass = $(this).attr("class");

                    $(this).addClass("option-disabled");

                    // Add item to input
                    var thisInput = $(this)
                        .closest(".multiple-select-container")
                        .find(".input");


                    $(
                        "<li data-value='" +
                        optionValue +
                        "'>" +
                        optionText +
                        " <a href='#' class='remove-item'>&times;</a></li>"
                    ).insertBefore(thisInput);



                    // Get current value of select field
                    var currentValues = $(this)
                        .closest(".multiple-select-container")
                        .siblings("select")
                        .val();

                    // Add values to select field
                    currentValues.push(optionValue);

                    // Assign updated value to select field
                    $(this)
                        .closest(".multiple-select-container")
                        .siblings("select")
                        .val(currentValues);

                    // Make choices active, remove input placeholder
                    $(".multiple-select-choices li").addClass("choice-active");
                    $(".multiple-select-choices li input").attr("placeholder", "").focus();

                    // Hide dropdown
                    $(this).closest(".multiple-select-dropdown").hide();

                    $(document).trigger("multipleSelectItemAdded", [
                        optionText,
                        optionValue,
                        optionClass,
                    ]);
                }
            );

            // Remove item
            $(document).on("click", ".multiple-select-choices li a", function() {
                var optionText = $(this).closest("li").text(),
                    optionValue = $(this).closest("li").data("value"),
                    optionClass = $(this).closest("li").attr("class");

                // Re-enable option in dropdown
                $(
                    ".multiple-select-dropdown li[data-value='" + optionValue + "']"
                ).removeClass("option-disabled");

                // Get current value of the select field
                var currentValues = $(this)
                    .closest(".multiple-select-container")
                    .siblings("select")
                    .val();

                // If the removed item is in the select value, remove it
                var index = currentValues.indexOf(optionValue);

                if (index > -1) {
                    currentValues.splice(index, 1);
                }

                // Re-assign the new value to the select field
                $(this)
                    .closest(".multiple-select-container")
                    .siblings("select")
                    .val(currentValues);

                // Return placeholder to input if no choices have been made
                if (currentValues.length == 0) {
                    $(this)
                        .closest(".multiple-select-choices")
                        .find(".input")
                        .removeClass("choice-active")
                        .find("input")
                        .attr("placeholder", "Please select");
                }

                // Remove item from choices
                $(this).closest("li").remove();

                $(document).trigger("multipleSelectItemRemoved", [
                    optionText,
                    optionValue,
                    optionClass,
                ]);
            });
        });



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
            let weight = document.getElementById('weight').innerText;


            const arr = document.getElementsByClassName("choice-active");

            const flavour = Array.from(arr)
                .slice(0, -1)
                .map((node) => node.innerText.replace(" ×", ""));


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
                weight,
                cartDescription,
                sellingPrice,
                sellingPrice,
                mrp,
                flavour

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
