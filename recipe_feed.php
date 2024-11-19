<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit(); 
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Feed</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
</head>
<body>
    <body class="recipe-food-page"> <!-- Class to apply the background image for recipe food page -->

    <!-- Navigation Bar -->
    <nav class="navbar">
        <a href="index.php">Home</a>
        <a href="login.php">Login</a>
        <a href="register.php">Sign Up</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="explore_recipes.php">Recipe Management</a>
        <a href="users.php">User Management</a>
        <a href="logout.php">Log out</a>

    </nav>


    <!-- Search Bar -->
    <div class="search-bar">
        <input type="text" placeholder="Search recipes by name or keyword..." id="searchInput">
    </div>

    <!-- Recipe Container -->
    <div class="recipe-container">
        <div class="recipe-card">
            <img src=".one-pot-chicken-dinner-title.jpg" alt="One-Pot Chicken Dinner" class="recipe-img">
            <div class="recipe-details">
                <h2 class="recipe-title">One-Pot Chicken Dinner</h2>
                <p class="recipe-description">A quick and easy chicken dinner made in one pot.</p>
                <div class="recipe-rating">Rating: ★★★★☆</div>
            </div>
        </div>

        <div class="recipe-card">
            <img src="Chicken and Asparagus Skillet.jpg" alt="Chicken and Asparagus Skillet" class="recipe-img">
            <div class="recipe-details">
                <h2 class="recipe-title">Chicken and Asparagus Skillet</h2>
                <p class="recipe-description">Delicious chicken stir-fried with fresh asparagus.</p>
                <div class="recipe-rating">Rating: ★★★★☆</div>
            </div>
        </div>

        <div class="recipe-card">
            <img src="Chicken and Soup.jpg" alt="Chicken and Soup" class="recipe-img">
            <div class="recipe-details">
                <h2 class="recipe-title">Chicken</h2>
                <p class="recipe-description">A simple and classic chicken recipe.</p>
                <div class="recipe-rating">Rating: ★★★☆☆</div>
            </div>
        </div>

        <div class="recipe-card">
            <img src="Ghana Fufu.jpg" alt="Ghana Fufu" class="recipe-img">
            <div class="recipe-details">
                <h2 class="recipe-title">Ghana Fufu</h2>
                <p class="recipe-description">Traditional Ghanaian dish made from cassava and plantain.</p>
                <div class="recipe-rating">Rating: ★★★★★</div>
            </div>
        </div>

        <div class="recipe-card">
            <img src="Ghana Joll off rice.jpg" alt="Ghana Jollof Rice" class="recipe-img">
            <div class="recipe-details">
                <h2 class="recipe-title">Ghana Jollof Rice</h2>
                <p class="recipe-description">Spicy and flavorful rice dish.</p>
                <div class="recipe-rating">Rating: ★★★★☆</div>
            </div>
        </div>

        <div class="recipe-card">
            <img src=".Spaghetti and Slice Bread.jpg" alt="Spaghetti and Slice Bread" class="recipe-img">
            <div class="recipe-details">
                <h2 class="recipe-title">Spaghetti and Slice Bread</h2>
                <p class="recipe-description">Classic spaghetti served with sliced bread.</p>
                <div class="recipe-rating">Rating: ★★★☆☆</div>
            </div>
        </div>
    </div>

    
     
</body>
</html>
