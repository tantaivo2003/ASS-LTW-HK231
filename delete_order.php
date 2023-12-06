<?php
    include("database.php");

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['orderId'])) {
        $orderId = $_GET['orderId'];

        // Sử dụng prepared statement để ngăn chặn SQL injection
        $stmt = $conn->prepare("DELETE FROM donhang WHERE orderId = ?");
        $stmt->bind_param("i", $orderId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo '<script>alert("Order deleted successfully!")</script>';
            echo '<script>window.location.href = "order_management.php" </script>';
        } else {
            echo '<script>alert("User not found or error deleting order!")</script>';
        }

        // Đóng prepared statement
        $stmt->close();
    } else {
        echo '<script>alert("Order ID not provided!")</script>';
    }

    // Đóng kết nối
    $conn->close();
?>
