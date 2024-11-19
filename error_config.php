<?php

// Error reporting settings
error_reporting(E_ALL);
ini_set('display_errors', 'On'); // Consider setting to 'Off' in production

// Error logging configuration
$error_log_file = 'error.log'; // Adjust the log file path as needed

// Custom error handler
function customErrorHandler($errno, $errstr, $errfile, $errline) {
    global $error_log_file;

    // Log the error to a file
    error_log(date('[Y-m-d H:i:s]') . " Error: [$errno] $errstr in $errfile on line $errline\n", 3, $error_log_file);

    // Send an email notification (optional)
    // ...

    // Display a user-friendly error message
    echo "An error occurred. Please try again later.";
}

// Set the custom error handler
set_error_handler('customErrorHandler');
?>
