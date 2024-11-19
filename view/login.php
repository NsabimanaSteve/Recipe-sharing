<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login | Recipe Sharing Platform</title>
    <link rel="stylesheet" href="styles.css"> <!-- link to external CSS file -->
</head>
<body class="login-signup-page"> <!-- Class to apply the background image for login/signup pages -->
    <!-- Navigation Bar -->
    <nav class="navbar">
        <a href="index.html">Home</a>
        <a href="login.html">Login</a>
        <a href="register.html">Sign Up</a>
        <a href="dashboard.html">Dashboard</a>
        <a href="Recipes.html">Recipe Management</a>
        <a href="users.html">User Management</a>
    </nav>

    <!-- Welcome Message -->
    <div class="welcome-text">
        <h1>Welcome to Our Recipe Sharing Platform</h1>
    </div>

    <!-- Login Box -->
    <div class="login-box">
        <h1>Login</h1>
        <form id="loginForm" onsubmit="return validateForm()"> <!-- Form calls JavaScript function on submit -->
            <!-- Email Input -->
            <label for="email">Email</label>
            <input type="text" id="email" name="email" placeholder="Enter your email" required>

            <!-- Password Input -->
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>

            <!-- Login Button -->
            <button type="submit" class="login-button">Log In</button>
        </form>

        <?php
        if (isset($_GET['error'])) {
            echo '<p style="color: red;">' . $_GET['error'] . '</p>';
        }
        ?>

        <!-- Error Message Display -->
        <p id="errorMessage" style="color: red;"></p>

        <!-- Switch to Signup -->
        <div class="switch-account">
            <p>Don't have an account? <a href="register.html">Create an Account</a></p>
        </div>
    </div>
    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Recipe Sharing Platform. All Rights Reserved.</p>
        <p>
            <a href="privacy.html">Privacy Policy</a> | 
            <a href="terms.html">Terms of Service</a>
        </p>
        </footer>

    <script>
        // Function to validate the login form
        function validateForm() {
            // Get the values entered by the user
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const errorMessage = document.getElementById('errorMessage');

            // Regular expression for validating email format
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            // Regular expression for validating password complexity
            // Minimum 8 characters, at least 1 uppercase letter, 3 digits, 1 special character
            const passwordPattern = /^(?=.*[A-Z])(?=.*\d{3,})(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

            // Clear previous error message
            errorMessage.textContent = '';

            // Email validation
            if (!emailPattern.test(email)) {
                errorMessage.textContent = 'Please enter a valid email address.';
                return false; // Prevent form submission
            }

            // Password validation
            if (!passwordPattern.test(password)) {
                errorMessage.textContent = 'Password must be at least 8 characters long, contain at least one uppercase letter, at least three digits, and one special character.';
                return false; // Prevent form submission
            }

            // If validation passes, allow form submission
            return true;
        }
    </script>

</body>
</html>
