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

$sql = "SELECT * FROM sanpham WHERE productId='$id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$name = $row['name'];
$des = $row['description'];
$price = $row['price'];
$type = $row['productType'];
$img = $row['imageUrl'];

if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["submit"] == "Submit") {
        $name = $_POST["name"];
        $price = $_POST["price"];
        $des = $_POST["des"];
        $type = $_POST["type"];
        $img = $_POST["img"];

        if (empty($name) && $name != 0){
            echo '<script>alert("Nhập Name")</script>';
        }
        else if (strlen($name) < 5 || strlen($name) > 40) {
            echo '<script>alert("Name chuỗi từ 5-40 ký tự")</script>';
        }
        else if (empty($des) && $des != 0){
            echo '<script>alert("Nhập Description")</script>';
        }
        else if (strlen($des) > 5000) {
            echo '<script>alert("Description tối đa 5000 ký tự")</script>';
        }
        else if (empty($price) && $price != 0){
            echo '<script>alert("Nhập Price")</script>';
        }
        else if (!is_numeric($price)) {
            echo '<script>alert("Nhập Price kiểu số thực")</script>';
        }
        else if (empty($type) && $type != 0){
            echo '<script>alert("Nhập Type")</script>';
        }
        else if (strlen($type) > 50) {
            echo '<script>alert("Type không hợp lệ")</script>';
        }
        else if (empty($img) && $img != 0){
            echo '<script>alert("Nhập Image")</script>';
        }
        else if (strlen($img) > 255) {
            echo '<script>alert("Image tối đa 255 ký tự")</script>';
        } 
        else {
            $newsql = "UPDATE sanpham SET name='$name',description='$des',price='$price',productType='$type',imageUrl='$img' WHERE productId=$id";
            if ($conn->query($newsql) === TRUE) {
                echo '<script>alert("Đã chỉnh sửa thành công!")</script>';
                echo '<script>location.href = "product_admin.php" </script>';
            }
        }
    }
    if ($_POST["submit"] == "Clear") {
        $name = "";
        $des = "";
        $price = "";
        $type = "";
        $img = "";
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
    <div class="container mt-3" style="width: 600px">
        <h1 class="mt-5" style="color: white; text-align: center;">CHỈNH SỬA SẢN PHẨM</h1>
        <hr>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $id ?>">
            <label class="mt-2" for="name" style="color:white;">Tên sản phẩm</label>
            <input type="text" class="form-control mt-3" name="name" value='<?php echo $name ?>'>
            <label class="mt-2" for="des" style="color:white;">Mô tả</label>
            <input type="text" class="form-control mt-3" name="des" value='<?php echo $des ?>'>
            <label class="mt-2" for="price" style="color:white;">Giá</label>
            <input type="text" class="form-control mt-3" name="price" value='<?php echo $price ?>'>
            <label class="mt-2" for="type" style="color:white;">Hãng sản xuất</label>
            <input type="text" class="form-control mt-3" name="type" value='<?php echo $type ?>'>
            <label class="mt-2" for="img" style="color:white;">Link hình ảnh</label>
            <input type="text" class="form-control mt-3" name="img" placeholder="Image" value='<?php echo $img ?>'>

            <div class="row">
                <div class="col">
                    <input type="submit" class="form-control btn mt-3" name="submit" value="Xác nhận" style="background-color:#FF8C00; color:white;">
                </div>
                <div class="col">
                    <input type="submit" class="form-control btn btn-danger mt-3" name="submit" value="Xóa thông tin đã nhập">
                </div>
            </div>
            <a class="form-control btn btn-secondary mt-3" href="product_admin.php">Hủy</a><br>

        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>