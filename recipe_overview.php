<?php


// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}
// recipe_overview.php
session_start();
require_once 'config.php'; // Database configuration
require_once 'functions.php'; // Utility functions like isAdmin(), getAllRecipes(), deleteRecipe()

// Check if the user is logged in and has admin access
if (!isset($_SESSION['user_id']) || !isAdmin()) {
    header("Location: login.php");
    exit();
}

// Handle recipe deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_recipe_id'])) {
    $recipeId = $_POST['delete_recipe_id'];
    deleteRecipe($recipeId);
}

// Fetch all recipes or search/filter if query is set
$recipes = [];
if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
    $recipes = searchRecipes($searchQuery);
} else if (isset($_GET['category'])) {
    $category = $_GET['category'];
    $recipes = getRecipesByCategory($category);
} else {
    $recipes = getAllRecipes();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Overview</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="recipe-overview-container">
    <h1>Recipe Overview</h1>
    
    <!-- Search and Filter Form -->
    <form method="GET" class="search-filter-form">
        <input type="text" name="search" placeholder="Search by name" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <select name="category">
            <option value="">All Categories</option>
            <option value="Appetizer" <?php if (isset($_GET['category']) && $_GET['category'] == 'Appetizer') echo 'selected'; ?>>Appetizer</option>
            <option value="Main Course" <?php if (isset($_GET['category']) && $_GET['category'] == 'Main Course') echo 'selected'; ?>>Main Course</option>
            <option value="Dessert" <?php if (isset($_GET['category']) && $_GET['category'] == 'Dessert') echo 'selected'; ?>>Dessert</option>
        </select>
        <button type="submit">Filter</button>
    </form>

    <!-- Recipe Table -->
    <table class="recipe-table">
        <thead>
            <tr>
                <th>Recipe Name</th>
                <th>Category</th>
                <th>Ingredients</th>
                <th>Created Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recipes as $recipe): ?>
                <tr>
                    <td><?php echo htmlspecialchars($recipe['name']); ?></td>
                    <td><?php echo htmlspecialchars($recipe['category']); ?></td>
                    <td><?php echo htmlspecialchars($recipe['ingredients']); ?></td>
                    <td><?php echo htmlspecialchars($recipe['created_date']); ?></td>
                    <td>
                        <a href="view_recipe.php?id=<?php echo $recipe['id']; ?>">View</a>
                        <a href="edit_recipe.php?id=<?php echo $recipe['id']; ?>">Edit</a>
                        <form method="POST" class="delete-form" style="display:inline;">
                            <input type="hidden" name="delete_recipe_id" value="<?php echo $recipe['id']; ?>">
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this recipe?');">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
