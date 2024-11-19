<?php
// Include the database connection file
include 'config.php';

// Retrieve user input
$username = $_POST['signup-username'];
$email = $_POST['signup-email'];
$password = $_POST['signup-password'];

// Hash the password for security
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert user data into the database
$sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";

if (mysqli_query($conn, $sql)) {
    // Successful registration
    header("Location: login.html?success=Registration successful");
    exit();
} else {
    // Registration failed
    header("Location: register.html?error=Registration failed");
    exit();
}

$conn->close();
?>