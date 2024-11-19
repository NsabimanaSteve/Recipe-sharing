<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create an Account | Recipe Sharing Platform</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="login-signup-page">

    <nav class="navbar">
        <a href="index.php">Home</a>
        <a href="login.php">Login</a>
        <a href="register.php">Sign Up</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="explore_recipes.php">Recipe Management</a>
        <a href="users.php">User Management</a>
        <a href="logout.php">Log out</a>

    </nav>

    <div class="welcome-text">
        <h1>Welcome to Our Recipe Sharing Platform</h1>
    </div>

    <div class="login-box">
        <h1>Create an Account</h1>
        <form id="registrationForm" action="register_action.php" method="POST" onsubmit="return validateForm()">
            <label for="fname">First Name</label>
            <input type="text" id="fname" name="fname" placeholder="Enter your first name" required>

            <label for="lname">Last Name</label>
            <input type="text" id="lname" name="lname" placeholder="Enter your last name" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Create a password" required>

            <label for="confirm-password">Confirm Password</label>
            <input type="password" id="confirm-password" name="confirm-password" placeholder="Re-enter your password" required>

            <label for="signup-role">Role</label>
            <select id="signup-role" name="signup-role" required>
                <option value="Regular Admin">Regular Admin</option>
                <option value="Supper Admin">Supper Admin</option>
            </select>

            <button type="submit" class="login-button">Sign Up</button>
        </form>

        <p id="errorMessage" style="color: red;">
            <?php session_start(); echo $_SESSION['error_message'] ?? ''; ?>
        </p>
    </div>

    <footer>
        <p>&copy; 2024 Recipe Sharing Platform. All Rights Reserved.</p>
        <p>
            <a href="privacy.html">Privacy Policy</a> | 
            <a href="terms.html">Terms of Service</a>
        </p>
    </footer>

    <script>
        function validateForm() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm-password').value;
            const errorMessage = document.getElementById('errorMessage');

            if (password !== confirmPassword) {
                errorMessage.textContent = 'Passwords do not match.';
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
