<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | Recipe Sharing Platform</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to external CSS file -->
</head>
<body class="index-page"> <!-- Class to apply the background image for login/signup pages -->

    <!-- Navigation Bar -->
    <nav class="navbar">
        <a href="index.php">Home</a>
        <a href="login.php">Login</a>
        <a href="register.php">Sign Up</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="explore_recipes.php">Recipe Management</a>
        <a href="users.php">User Management</a>
        <a href="logout.php">Log outt</a>

    </nav>

    <!-- Welcome Section with Call-to-Action -->
    <div class="welcome-section">
        <h1>Welcome to Our Recipe Sharing Platform</h1>
        <p>Discover, share, and enjoy delicious recipes from our community!</p>
        <a href="recipe_feed.php" class="get-started-btn">Get Started</a>
    </div>

    <!-- Recipe Image Gallery Section -->
    <div class="gallery-section">
        <h2>Featured Recipes</h2>
        <div class="image-gallery">
            <figure>
                <img src=".one-pot-chicken-dinner-title.jpg" alt="One-Pot Chicken Dinner" class="recipe-img">
                <figcaption>One-Pot Chicken Dinner</figcaption>
            </figure>
            <figure>
                <img src="Chicken and Asparagus Skillet.jpg" alt="Chicken and Asparagus Skillet" class="recipe-img">
                <figcaption>Chicken and Asparagus Skillet</figcaption>
            </figure>
            <figure>
                <img src="Chicken.jpg" alt="Chicken" class="recipe-img">
                <figcaption>Chicken</figcaption>
            </figure>
            <figure>
                <img src="Ghana Fufu.jpg" alt="Ghana Fufu" class="recipe-img">
                <figcaption>Ghana Fufu</figcaption>
            </figure>
            <figure>
                <img src="Ghana Joll off rice.jpg" alt="Ghana Jollof Rice" class="recipe-img">
                <figcaption>Ghana Jollof Rice</figcaption>
            </figure>
            <figure>
                <img src=".Spaghetti and Slice Bread.jpg" alt="Spaghetti and Slice Bread" class="recipe-img">
                <figcaption>Spaghetti and Slice Bread</figcaption>
            </figure>
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

</body>
</html>
