<?php
// Database connection parameters
$servername = "localhost";  // Hostname (use 'localhost' for XAMPP)
$username = "root";         // MySQL username (default in XAMPP)
$password = "";             // MySQL password (default is empty in XAMPP)
$dbname = "DBfootball";  // The name of your database

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>