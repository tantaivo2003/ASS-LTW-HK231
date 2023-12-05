<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "ltw_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET["id"];
if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["submit"] == "Delete") {
        $sql = "DELETE FROM sanpham WHERE productId = '$id'";
        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Đã xóa thành công!")</script>';
            echo '<script>location.href = "product_admin.php" </script>';
        }
    } 
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time Elite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body style="background-color:black;">
    <div class="container mt-3" style="width: 600px;">
        <h1 class="mt-5" style="color: white; text-align: center;">XÁC NHẬN XÓA SẢN PHẨM?</h1>
        <hr>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $id ?>">
            <input type="submit" class="form-control btn mt-3" name="submit" value="Xóa" style="background-color:#FF8C00; color:white;">
            <a class="form-control btn btn-dark mt-3" href="product_admin.php">Hủy</a><br>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>