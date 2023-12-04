<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "ltw_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $img = $name = $price = $type = $des = "";
$sql = "SELECT * FROM sanpham";
$result = $conn->query($sql);

if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["submit"] == "Create") {
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $name = $_POST["name"];
        $price = $_POST["price"];
        $des = $_POST["des"];
        $type = $_POST["type"];
        $img = $_POST["img"];

        if (empty($id) && $id != 0) {
            echo '<script>alert("Nhập ID")</script>';
        } 
        else if (!preg_match("/^[0-9]{1,100}$/", $id)) {
            echo '<script>alert("ID kiểu số nguyên")</script>';
        }
        else if (empty($name) && $name != 0){
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
            $test = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if ($id == $row["id"]) {
                        echo '<script>alert("ID đã tồn tại")</script>';
                        $test = 1;
                    }
                }
            }
            if ($test == 0) {
                $newsql = "INSERT INTO sanpham (productId, name, description, price, productType, imageUrl) VALUES ('$id', '$name', '$des', '$price', '$type', '$img')";

                if ($conn->query($newsql) === TRUE) {
                    echo '<script>alert("Đã tạo thành công!")</script>';
                    echo '<script>location.href = "product_admin.php"</script>';
                }
            }

        }
    }
    if ($_POST["submit"] == "Clear") {
        $id = "";
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
        <h1 class="mt-5" style="color: white; text-align: center;">CREATE NEW PRODUCT</h1>
        <hr>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
            <label class="mt-2" for="id" style="color:white;">Product ID</label>
            <input type="text" class="form-control mt-3" name="id" value='<?php echo $id ?>'>
            <label class="mt-2" for="name" style="color:white;">Name</label>
            <input type="text" class="form-control mt-3" name="name" value='<?php echo $name ?>'>
            <label class="mt-2" for="des" style="color:white;">Description</label>
            <input type="text" class="form-control mt-3" name="des" value='<?php echo $des ?>'>
            <label class="mt-2" for="price" style="color:white;">Price</label>
            <input type="text" class="form-control mt-3" name="price" value='<?php echo $price ?>'>
            <label class="mt-2" for="type" style="color:white;">Product Type</label>
            <input type="text" class="form-control mt-3" name="type" value='<?php echo $type ?>'>
            <label class="mt-2" for="img" style="color:white;">Image URL</label>
            <input type="text" class="form-control mt-3" name="img" value='<?php echo $img ?>'>

            <div class="row">
                <div class="col">
                    <input type="submit" class="form-control btn mt-3" name="submit" value="Create" style="background-color:#FF8C00; color:white;">
                </div>
                <div class="col">
                    <input type="submit" class="form-control btn btn-danger mt-3" name="submit" value="Clear">
                </div>
            </div>
            <a class="form-control btn btn-secondary mt-3" href="product_admin.php">Cancel</a><br>

        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>