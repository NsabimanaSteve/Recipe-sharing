<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create an Account | Recipe Sharing Platform</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to external CSS file -->
</head>
<body class="login-signup-page"> <!-- Class for applying the background image for login/signup pages -->
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

    <!-- Sign-Up Box -->
    <div class="login-box">
        <h1>Create an Account</h1>
        <form id="registrationForm" onsubmit="return validateForm()"> <!-- Attach validateForm function -->
            <!-- Username Field -->
            <label for="signup-username">Username</label>
            <input type="text" id="signup-username" name="signup-username" placeholder="Enter your username" required>

            <!-- Email Field -->
            <label for="signup-email">Email</label>
            <input type="email" id="signup-email" name="signup-email" placeholder="Enter your email" required>

            <!-- Password Field -->
            <label for="signup-password">Password</label>
            <input type="password" id="signup-password" name="signup-password" placeholder="Create a password" required>

            <!-- Confirm Password Field -->
            <label for="signup-confirm-password">Confirm Password</label>
            <input type="password" id="signup-confirm-password" name="signup-confirm-password" placeholder="Re-enter your password" required>

            <!-- Submit Button -->
            <button type="submit" class="login-button">Sign Up</button>
        </form>

        <!-- Error Message Display -->
        <p id="errorMessage" style="color: red;"></p>

        <!-- Switch to Login -->
        <div class="switch-account">
            <p>Already have an account? <a href="login.html">Log In</a></p>
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
        // Function to validate the registration form
        function validateForm() {
            const username = document.getElementById('signup-username').value;
            const email = document.getElementById('signup-email').value;
            const password = document.getElementById('signup-password').value;
            const confirmPassword = document.getElementById('signup-confirm-password').value;
            const errorMessage = document.getElementById('errorMessage');

            // Clear previous error message
            errorMessage.textContent = '';

            // Regular expression for validating email format
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            // Regular expression for validating password complexity
            const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=(.*\d){3})(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

            // Validate fields
            if (!username || !email || !password || !confirmPassword) {
                errorMessage.textContent = 'Please fill in all fields.';
                return false; // Prevent form submission
            }

            // Email validation
            if (!emailPattern.test(email)) {
                errorMessage.textContent = 'Please enter a valid email address.';
                return false; // Prevent form submission
            }

            // Password validation
            if (!passwordPattern.test(password)) {
                errorMessage.textContent = 'Password must be at least 8 characters long, contain at least one uppercase letter, three digits, and one special character.';
                return false; // Prevent form submission
            }

            // Confirm password validation
            if (password !== confirmPassword) {
                errorMessage.textContent = 'Passwords do not match. Please try again.';
                return false; // Prevent form submission
            }

            // If validation passes, allow form submission
            return true;
        }
    </script>
</body>
</html>
