<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "recipe_sharing";

// Create connection using mysqli
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set character encoding to avoid issues with special characters
$conn->set_charset("utf8");
?>
