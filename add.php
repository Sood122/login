<?php  
require_once 'db_connect.php';

$product_name = $product_price = $product_img = "";
$product_name_err = $product_price_err = $product_img_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST"){

    // Check if product_name is empty
    if(empty(trim($_POST["product_name"]))){
        $product_name_err = "product_name cannot be blank";
    }
    else{
        $sql = "SELECT id FROM users WHERE product_name = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt)
        {
            mysqli_stmt_bind_param($stmt, "s", $param_product_name);

            // Set the value of param product_name
            $param_product_name = trim($_POST['product_name']);

            // Try to execute this statement
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    $product_name_err = "This product_name is already taken"; 
                }
                else{
                    $product_name = trim($_POST['product_name']);
                }
            }
            else{
                echo "Something went wrong";
            }
        }
    }

    mysqli_stmt_close($stmt);


// Check for product_price
if(empty(trim($_POST['product_price']))){
    $product_price_err = "product_price cannot be blank";
}
else{
    $product_price = trim($_POST['product_price']);
}

// check for product_img
if (empty($_FILES["product_img"])) {
    $product_img_err = "Please select an image";
} else {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["product_img"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));


    // If there are no errors, try to upload the file
    if (empty($product_img_err)) {
        $new_file_name = md5(basename($_FILES["product_img"]["name"]) . time()) . "." . $imageFileType;
        $new_target_file = $target_dir . $new_file_name;

        if (move_uploaded_file($_FILES["product_img"]["tmp_name"], $new_target_file)) {
            $product_img = $new_file_name;
        } else {
            $product_img_err = "Sorry, there was an error uploading your file.";
        }
    }
}


// If there were no errors, go ahead and insert into the database
if(empty($product_name_err) && empty($product_price_err) && empty($product_img_err))
{
    $sql = "INSERT INTO `users`(`product_name`, `product_price`, `product_img`) VALUES ('$product_name','$product_price','$product_img')";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt)
    {
        mysqli_stmt_bind_param($stmt, "ss", $param_product_name, $param_product_price);

        // Set these parameters
        $param_product_name = $product_name;

        // Try to execute the query
        if (mysqli_stmt_execute($stmt))
        {
            header("location: list.php");
        }
        else{
            echo "Something went wrong";
        }
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  <body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand">Welcome </a>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link active" href="add.php">New product</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="list.php">Products</a>
      </li>
    </ul>
    
  </div>
</nav>

  <div class="container mt-5 w-75 p-3 border border-2 mr-3" style="margin: 160px">

      
      <form method="POST" action="" enctype="multipart/form-data">
          <div class="mb-3">
              <label for="product_name" class="form-label">Product Name</label>
              <input type="text" class="form-control" id="product_name" name="product_name" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="product_price" class="form-label">Product Price</label>
                <input type="number" class="form-control" id="product_price" name="product_price">
            </div>

            <div class="mb-3">
                <label for="product_img" class="form-label">Product image</label>
                <input type="file" class="form-control" id="product_img" name="product_img">
            </div>
            
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
    </html>