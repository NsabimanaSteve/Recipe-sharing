<?php
session_start();

//iclude the database connection
include "config.php";
// Retrieve user input
$email = $_POST['email'];
$password = $_POST['password'];

// Hash the password for secure comparison
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// SQL query to check user credentials
$sql = "SELECT * FROM users WHERE email='$email' AND password='$hashed_password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Successful login
    $_SESSION['logged_in'] = true;
    $_SESSION['email'] = $email;
    header("Location: dashboard.html");
    exit();
} 
else {
    // Login failed
    header("Location: login.html?error=Invalid email or password");
    exit();
}

$conn->close();
?>