<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "ltw_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Time Elite</title>
</head>

<body style="background-color:black;">
    <a class="btn mt-3" href="index_admin.php" style="background-color:#FF8C00; color:white; margin-left: 20px;">Go Back</a>
    <hr size="5px" color="#FF8C00">
    <div class="container">
        <h1 class="mt-1" style="color: white; text-align: center;">PRODUCTS LIST</h1>
        <hr>
        <a class="btn mt-2" href="add_product.php" style="background-color:#FF8C00; color:white;">Create New Product</a>

        <table class="table table-bordered mt-3 table table-dark table-striped" style="text-align:justify;">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Price</th>
                <th scope="col">Type</th>
                <th scope="col">Action</th>
            </tr>
            <?php
            $sql = "SELECT * FROM sanpham";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo
                        "<tr>
                            <td>" . $row["productId"] . "</td>
                            <td class='col-3'>" . $row["name"] . "</td>
                            <td>" . $row["description"] . "</tdclass>
                            <td>" . $row["price"] . "$</td>
                            <td>" . $row["productType"] . "</td>
                            <td class='col-2'>
                                <a href='edit_product.php?id=" . $row["productId"] . "' class='btn' style='background-color:#FF8C00; color:white;'>Edit</a>
                                <a href='delete_product.php?id=" . $row["productId"] . "' class='btn btn-secondary ms-3'>Delete</a>
                            </td>
                        </tr>";
                }
            }
            ?>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>

