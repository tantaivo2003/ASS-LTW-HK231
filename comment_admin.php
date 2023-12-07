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

<body style="background-color:#eee;">
    <div class="container" style="background-color:white;">
        <a class="btn mt-3" href="admin_page.php"
            style="background-color:#FF8C00; color:white; margin-left: 20px;">Quay
            lại</a>
        <hr size="5px" color="#FF8C00">
        <h1 class="mt-1" style="text-align: center;">BÌNH LUẬN CỦA KHÁCH HÀNG</h1>
        <hr>

        <table class="table table-bordered mt-3 table table-striped" style="text-align:center;">
            <tr>
                <th scope="col">Tên khách hàng</th>
                <th scope="col">ID sản phẩm</th>
                <th scope="col">Đánh giá</th>
                <th scope="col">Bình luận</th>
                <th scope="col">Ngày bình luận</th>
                <th scope="col">Chức năng</th>
            </tr>
            <?php
            $sql = "SELECT * FROM nguoidungdanhgiasp ";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo
                        "
                        <tr>
                            <td>" . $row["rUsername"] . "</td>
                            <td>" . $row["rProductId"] . "</td>
                            <td>" . $row["numberStar"] . " sao</td>
                            <td>" . $row["comment"] . "</td>
                            <td>" . $row["dateComment"] . "</td>
                            <td class='col-3'>
                                <a href='detail_product.php?id=" . $row["rProductId"] . "' class='btn' style='background-color:#FF8C00; color:white;'>Xem chi tiết sản phẩm</a>
                                <a href='delete_comment.php?id=" . $row["rProductId"] . "&uid=" . $row["rUsername"] . "' class='btn ms-4' style='background-color:#FF8C00; color:white;'>Xóa</a>
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