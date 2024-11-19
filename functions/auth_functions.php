<?php

function registerUser($pdo, $fname, $lname, $email, $password) {
    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute the SQL query
    $sql = "INSERT INTO users (fname, lname, email, password) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$fname, $lname, $email, $hashed_password]);
}

function loginUser($pdo, $email, $password) {
    // Prepare and execute the SQL query to retrieve user information
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify password using password_verify()
    if ($user && password_verify($password, $user['password'])) {
        // Start a session and store user information
        session_start();
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_email'] = $user['email'];
        return true;
    } else {
        return false;
    }
}

function logoutUser() {
    // Clear session data
    session_start();
    session_destroy();
}

function isLoggedIn() {
    session_start();
    return isset($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        // Redirect to login page or show an error message
        header('Location: login.php');
        exit();
    }
}