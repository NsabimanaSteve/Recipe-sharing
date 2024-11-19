<?php
session_start();  // Ensure session is started at the beginning


// Include your database connection (assuming it's included already)
include 'config.php';
//$conn = connectDatabase();


// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize user inputs
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check if email and password are provided
    if (empty($email) || empty($password)) {
        $_SESSION['error_message'] = "Please enter both email and password.";
        header("Location: login.php");
        exit();
    }

    // Check login attempts
    if (isset($_SESSION['login_attempts']) && $_SESSION['login_attempts'] >= 5) {
        // If user attempted to log in more than 5 times, prevent login for 15 minutes
        $last_attempt_time = $_SESSION['last_attempt_time'] ?? 0;
        if (time() - $last_attempt_time < 900) { // 15 minutes in seconds
            $_SESSION['error_message'] = "Too many login attempts. Please try again after 15 minutes.";
            header("Location: login.php");
            exit();
        } else {
            // Reset login attempts after 15 minutes
            $_SESSION['login_attempts'] = 0;
        }
    }

    // Database connection and query preparation
    //$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL statement to select user based on email
    $sql = "SELECT user_id, fname, lname, password, role FROM users WHERE email = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        // Bind the email parameter to the query
        $stmt->bind_param("s", $email);
        $stmt->execute();
        
        // Store the result to check if email exists
        $stmt->store_result();
        
        // Debugging: Check number of rows returned
        echo "Number of rows found: " . $stmt->num_rows . "<br>"; // Debugging line

        // If email exists in the database
        if ($stmt->num_rows > 0) {
            // Bind the result variables
            $stmt->bind_result($user_id, $fname, $lname, $hashedPassword, $role);
            $stmt->fetch();
            
            // Verify password
            if (password_verify($password, $hashedPassword)) {
                // Regenerate session ID for security
                session_regenerate_id(true);
                
                // Set session variables
                $_SESSION['user_id'] = $user_id;
                $_SESSION['fname'] = $fname;
                $_SESSION['lname'] = $lname;
                $_SESSION['role'] = $role;
                
                // Redirect to dashboard
                header("Location: dashboard.php");
                exit();
            } else {
                // Incorrect password
                $_SESSION['error_message'] = "Incorrect password.";
                header("Location: login.php");
                exit();
            }
        } else {
            // Email does not exist in the database
            $_SESSION['error_message'] = "No account found with that email.";
            header("Location: login.php");
            exit();
        }
    } else {
        // SQL prepare error
        $_SESSION['error_message'] = "Error with the login query. Please try again later.";
        header("Location: login.php");
        exit();
    }
    
    // Close the statement and database connection
    $stmt->close();
    $conn->close();
}
?>
