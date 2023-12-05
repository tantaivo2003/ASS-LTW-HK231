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

$display = $row['display'];
$display = 1 - $row['display'];
$newsql = "UPDATE sanpham SET display='$display' WHERE productId=$id";
if ($conn->query($newsql) === TRUE) {
    echo '<script>location.href = "product_admin.php" </script>';
}
?>