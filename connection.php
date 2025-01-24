<?php
// Connect to the database
$servername = "localhost";
$port = "80";
$username = "root";
$password = "";
$dbname = "np_b_alpha";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connection successful!";
}
?>
