<?php
// Start session for error and success messages
session_start();

// Include the database connection file
include 'config.php';
//$conn = connectDatabase();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $fname = htmlspecialchars(trim($_POST['fname']));
    $lname = htmlspecialchars(trim($_POST['lname']));
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];

    // Capture the role selection from the form
    $roleSelection = $_POST['signup-role'];

    // Set the role based on the selection
    $role = ($roleSelection == "Supper Admin") ? 1 : 2;  // 1 for Super Admin, 2 for Regular Admin

    // Initialize error message
    $errorMessage = "";

    // Validation
    if (empty($fname) || empty($lname) || empty($email) || empty($password) || empty($confirmPassword)) {
        $errorMessage = "Please fill in all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "Please enter a valid email address.";
    } elseif ($password !== $confirmPassword) {
        $errorMessage = "Passwords do not match.";
    } elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=(.*\d){3})(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $password)) {
        $errorMessage = "Password must be at least 8 characters, with at least one uppercase letter, three digits, and a special character.";
    }

    // If there's an error, redirect with a message
    if ($errorMessage) {
        $_SESSION['error_message'] = $errorMessage;
        header('Location: register.php');
        exit;
    }

    // Check if email already exists
    $emailCheckQuery = "SELECT user_id FROM users WHERE email = ?";
    $stmt = $conn->prepare($emailCheckQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['error_message'] = "An account with this email address already exists. Please try logging in or use a different email to register.";
        header('Location: register.php');
        $stmt->close();
        $conn->close();
        exit;
    }
    $stmt->close();

    // Hash the password securely
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Timestamps for registration
    $createdAt = $updatedAt = date("Y-m-d H:i:s");

    // Insert user into the database
    $sql = "INSERT INTO users (fname, lname, email, password, role, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssiss", $fname, $lname, $email, $hashedPassword, $role, $createdAt, $updatedAt);

    if ($stmt->execute()) {
        // Success message
        $_SESSION['success_message'] = "Registration successful! Please log in.";
        header("Location: login.php");
        exit();
    } else {
        error_log("Database Error: " . $stmt->error);
        $_SESSION['error_message'] = "An error occurred. Please try again.";
        header('Location: register.php');
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>
