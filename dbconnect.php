<?php
// Database configuration
$servername = "localhost";
$username = "root";       // Default username for XAMPP
$password = "";           // Default password for XAMPP is empty
$dbname = "networking_platform";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: Set charset to utf8 (recommended)
$conn->set_charset("utf8");

// For debugging (optional)
// echo "Connected successfully!";
?>