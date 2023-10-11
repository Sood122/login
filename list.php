<?php
require_once 'db_connect.php'
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Product List</title>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand">Welcome </a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="add.php">New product</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="list.php">Products</a>
                </li>
            </ul>

        </div>
    </nav>

    <div class="container mt-5">
        <button class="btn btn-primary"><a href="add.php" class="text-light" style="text-decoration: none;">Add product</a></button>
    </div>
    <div class="list_section mt-5 w-75 p-3 border border-2 mr-3" style="margin: 86px">
        <table class="table" id="tableData">
            <thead>
                <tr>
                    <th scope="col">S.no</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Product Price</th>
                    <th scope="col">Product image</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM `users`";
                $result = mysqli_query($conn, $sql);
                $sno = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $sno = $sno + 1;
                    echo "<tr>
            <th scope='row'>" . $sno . "</th>
            <td>" . $row['product_name'] . "</td>
            <td>" . $row['product_price'] . "</td>
            <td><img src='uploads/" . $row['product_img'] . "' width='80' height='80'></td>
            </tr>";
                }
                ?>
            </tbody>

        </table>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>

</body>
<!-- Paging JS -->
<script type="text/javascript" src="paging.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#tableData').paging({
            limit: 5
        });
    });
</script>

</html>