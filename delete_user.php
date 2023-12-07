<?php
    include("database.php");

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['username'])) {
        $username = $_GET['username'];

        // prepared statement 
        $stmt = $conn->prepare("DELETE FROM khachhang WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo '<script>alert("User deleted successfully!")</script>';
            echo '<script>window.location.href = "user_management.php" </script>';
        } else {
            echo '<script>alert("User not found or error deleting user!")</script>';
        }

        // Đóng prepared statement
        $stmt->close();
    } else {
        echo '<script>alert("Username not provided!")</script>';
    }

    // Đóng kết nối
    $conn->close();
?>
