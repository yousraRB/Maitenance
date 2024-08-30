<?php
// Start session
session_start();

//Connect to database
$host = "localhost";
$password = "";
$username = "root";
$db_name = "maintenance";
$conn = new mysqli($host, $username, $password, $db_name);

if ($conn->connect_error) {
    // This function prints an error message
    die("Error: Connection failed" . $conn->connect_error);
}

?>