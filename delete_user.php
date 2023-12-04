<?php
    include("database.php");

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['username'])) {
        $username = $_GET['username'];

        $sql = "DELETE FROM khachhang WHERE username=$username"; 

        if ($conn->query($sql) === TRUE) {
            echo "User deleted successfully!";
        } else {
            echo "Error deleting user: " . $conn->error;
        }
    } else {
        echo "Username not provided";
    }

    // Close connection
    $conn->close();
?>