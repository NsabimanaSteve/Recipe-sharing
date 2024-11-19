<?php
session_start();
include 'config.php';

// Check if the user is logged in and has Super Admin role
if (!isset($_SESSION['user_id']) || get_user_role($_SESSION['user_id']) != 1) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Delete user query
    $query = "DELETE FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    
    if ($stmt->execute()) {
        header('Location: user.php'); // Redirect back to user management page
    } else {
        echo "Error deleting user.";
    }
}
// Define the function to get user role
function get_user_role($user_id) {
    global $conn; // Use $conn, since that's the variable for the connection

    // Prepare the SQL query
    $stmt = $conn->prepare("SELECT role FROM users WHERE user_id = ?");
    
    if ($stmt === false) {
        // Prepare failed, output error message
        die('MySQL prepare error: ' . $conn->error);
    }

    // Bind the parameter
    $stmt->bind_param("i", $user_id);

    // Execute the statement
    $stmt->execute();

    // Get the result and fetch the role
    $result = $stmt->get_result()->fetch_assoc();

    return $result['role'] ?? null; // Return the role or null if not found
}
?>
