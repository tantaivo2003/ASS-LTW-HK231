<?php
// define 

// Connect to db
$DB_host = 'localhost';
$DB_username = 'root';
$DB_password = '';
$DB_database = 'altw_db'; 

$conn = new mysqli($DB_host, $DB_username, $DB_password, $DB_database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>