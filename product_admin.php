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
    <a class="btn mt-3" href="index_admin.php" style="background-color:#FF8C00; color:white; margin-left: 20px;">Quay
        lại</a>
    <hr size="5px" color="#FF8C00">
    <div class="container">
        <h1 class="mt-1" style="color: white; text-align: center;">DANH SÁCH SẢN PHẨM</h1>
        <hr>
        <a class="btn mt-2" href="add_product.php" style="background-color:#FF8C00; color:white;">Tạo sản phẩm mới</a>

        <table class="table table-bordered mt-3 table table-dark table-striped" style="text-align:center;">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Tên sản phẩm</th>
                <th scope="col">Mô tả</th>
                <th scope="col">Giá</th>
                <th scope="col">Hãng sản xuất</th>
                <th scope="col">Hiển thị</th>
                <th scope="col">Chức năng</th>
            </tr>
            <?php
            $sql = "SELECT * FROM sanpham";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo
                        "
                        <tr>
                            <td>" . $row["productId"] . "</td>
                            <td class='col-2'>" . $row["name"] . "</td>
                            <td style='text-align:justify;'>" . $row["description"] . "</tdclass>
                            <td>" . $row["price"] . "$</td>
                            <td>" . $row["productType"] . "</td>
                            <td>" . $row["display"] . "</td>
                            <td class='col-2'>
                                <a href='detail_product.php?id=" . $row["productId"] . "' class='btn mt-3' style='background-color:#FF8C00; color:white;'>Xem chi tiết sản phẩm</a>
                                <a href='edit_product.php?id=" . $row["productId"] . "' class='btn mt-4' style='background-color:#FF8C00; color:white;'>Chỉnh sửa</a>
                                <a href='delete_product.php?id=" . $row["productId"] . "' class='btn mt-4 ms-4' style='background-color:#FF8C00; color:white;'>Xóa</a>
                                <a href='display_product.php?id=" . $row["productId"] . "' class='btn mt-4' style='background-color:#FF8C00; color:white;'>Ẩn / Hiện sản phẩm</a>
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