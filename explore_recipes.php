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
    <title>Recipes Management System</title>
    <link rel="stylesheet" href="stylesc.css">
</head>
<body>
    <div class="container">
        <!-- Header Section -->
        <header class="header">
            <h1>Food Recipe Dashboard</h1>
            <nav class="navbar">
                <a href="index.php">Home</a>
                <a href="login.php">Login</a>
                <a href="register.php">Sign Up</a>
                <a href="dashboard.php">Dashboard</a>
                <a href="explore_recipes.php">Recipe Management</a>
                <a href="users.php">User Management</a>
                <a href="logout.php">Log out</a>


            </nav>
        </header>

        
        <h1>Recipes Management System</h1>

        <!-- Form for adding and editing recipes -->
        <form id="recipeForm">
            <input type="text" id="title" placeholder="Recipe Title" required><br>
            <input type="text" id="origin" placeholder="Origin (e.g., Country or Region)" required><br>
            <textarea id="ingredients" placeholder="Ingredients (comma separated)" required></textarea><br>
            <textarea id="nutritionalValue" placeholder="Nutritional Value (e.g., Protein, Carbs)" required></textarea><br>
            <input type="text" id="allergenInfo" placeholder="Allergen Information" required><br>
            <input type="text" id="shelfLife" placeholder="Shelf Life" required><br>
            <input type="number" id="quantity" placeholder="Quantity" min="1" required><br>
            <input type="text" id="unit" placeholder="Unit (e.g., cups, grams)" required><br>
            <input type="file" id="recipeImage" accept="image/*"><br>
            <input type="number" id="prepTime" placeholder="Preparation Time (Minutes)" min="0" required><br>
            <input type="number" id="cookTime" placeholder="Cooking Time (Minutes)" min="0" required><br>
            <input type="number" id="servingSize" placeholder="Serving Size" min="1" required><br>
            <textarea id="foodDescription" placeholder="Food Description" required></textarea><br>
            <input type="number" id="calories" placeholder="Calories per Serving" min="0" required><br>
            <input type="text" id="foodOrigin" placeholder="Food Origin" required><br>
            <textarea id="instructions" placeholder="Instructions" required></textarea><br>
            <button type="submit" id="submitBtn">Add Recipe</button>
        </form>

        <!-- Recipe Table -->
        <h2>Recipe List</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Origin</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="recipeTableBody">
                <!-- Recipes will be injected here -->
            </tbody>
        </table>

        <!-- Section for displaying recipe details -->
        <div id="recipeDetails" class="hidden">
            <h2>Recipe Details</h2>
            <p>ID: <span id="recipeId"></span></p>
            <p>Title: <span id="recipeTitle"></span></p>
            <p>Origin: <span id="recipeOrigin"></span></p>
            <p>Ingredients: <span id="recipeIngredients"></span></p>
            <p>Nutritional Value: <span id="recipeNutritionalValue"></span></p>
            <p>Allergen Information: <span id="recipeAllergenInfo"></span></p>
            <p>Shelf Life: <span id="recipeShelfLife"></span></p>
            <p>Instructions: <span id="recipeInstructions"></span></p>
            <button id="closeDetailsBtn">Close</button> <!-- Close button -->
        </div>
        
        <footer class="footer">
            <p>&copy; 2024 Recipe Sharing Platform. All Rights Reserved.</p>
        </footer>
    </div>

    <script>
        // app.js

        // Recipe storage
        let recipes = [];
        let isEditing = false;
        let currentRecipeId = null;

        // DOM elements
        const recipeForm = document.getElementById('recipeForm');
        const recipeTableBody = document.getElementById('recipeTableBody');
        const recipeDetails = document.getElementById('recipeDetails');
        const closeDetailsBtn = document.getElementById('closeDetailsBtn');

        // Event listener for form submission
        recipeForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent page refresh

            const title = document.getElementById('title').value.trim();
            const origin = document.getElementById('origin').value.trim();
            const ingredients = document.getElementById('ingredients').value.trim();
            const nutritionalValue = document.getElementById('nutritionalValue').value.trim();
            const allergenInfo = document.getElementById('allergenInfo').value.trim();
            const shelfLife = document.getElementById('shelfLife').value.trim();
            const quantity = parseInt(document.getElementById('quantity').value.trim());
            const unit = document.getElementById('unit').value.trim();
            const prepTime = parseInt(document.getElementById('prepTime').value.trim());
            const cookTime = parseInt(document.getElementById('cookTime').value.trim());
            const servingSize = parseInt(document.getElementById('servingSize').value.trim());
            const foodDescription = document.getElementById('foodDescription').value.trim();
            const calories = parseInt(document.getElementById('calories').value.trim());
            const foodOrigin = document.getElementById('foodOrigin').value.trim();
            const instructions = document.getElementById('instructions').value.trim();

            // Client-side validation for all fields
            if (!title || !origin || !ingredients || !nutritionalValue || !allergenInfo || 
                !shelfLife || !quantity || !unit || !prepTime || !cookTime || 
                !servingSize || !foodDescription || !calories || !foodOrigin || 
                !instructions) {
                alert('Please fill out all fields');
                return;
            }

            if (cookTime < 0 || prepTime < 0) {
                alert('Preparation and cooking times must be positive numbers');
                return;
            }

            if (isEditing) {
                updateRecipe(currentRecipeId, { title, origin, ingredients, nutritionalValue, allergenInfo, shelfLife, quantity, unit, prepTime, cookTime, servingSize, foodDescription, calories, foodOrigin, instructions });
            } else {
                addRecipe({ title, origin, ingredients, nutritionalValue, allergenInfo, shelfLife, quantity, unit, prepTime, cookTime, servingSize, foodDescription, calories, foodOrigin, instructions });
            }

            resetForm();
            renderTable();
        });

        // Add new recipe
        function addRecipe(recipe) {
            const newRecipe = {
                id: recipes.length + 1,  // Auto-increment ID
                ...recipe
            };
            recipes.push(newRecipe);
        }

        // Update an existing recipe
        function updateRecipe(id, updatedRecipe) {
            const recipeIndex = recipes.findIndex(r => r.id === id);
            if (recipeIndex !== -1) {
                recipes[recipeIndex] = { id, ...updatedRecipe };
                isEditing = false;
                currentRecipeId = null;
            }
        }

        // Delete a recipe
        function deleteRecipe(id) {
            if (confirm('Are you sure you want to delete this recipe?')) {
                recipes = recipes.filter(recipe => recipe.id !== id);
                renderTable();
            }
        }

        // Display recipe details
        function showRecipeDetails(id) {
            const recipe = recipes.find(r => r.id === id);
            if (recipe) {
                document.getElementById('recipeId').textContent = recipe.id;
                document.getElementById('recipeTitle').textContent = recipe.title;
                document.getElementById('recipeOrigin').textContent = recipe.origin;
                document.getElementById('recipeIngredients').textContent = recipe.ingredients;
                document.getElementById('recipeNutritionalValue').textContent = recipe.nutritionalValue;
                document.getElementById('recipeAllergenInfo').textContent = recipe.allergenInfo;
                document.getElementById('recipeShelfLife').textContent = recipe.shelfLife;
                document.getElementById('recipeInstructions').textContent = recipe.instructions;
                recipeDetails.classList.remove('hidden');
            }
        }

        // Render the recipe table
        function renderTable() {
            recipeTableBody.innerHTML = ''; // Clear table

            recipes.forEach(recipe => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${recipe.id}</td>
                    <td>${recipe.title}</td>
                    <td>${recipe.origin}</td>
                    <td>
                        <button onclick="showRecipeDetails(${recipe.id})">View</button>
                        <button onclick="editRecipe(${recipe.id})">Edit</button>
                        <button onclick="deleteRecipe(${recipe.id})">Delete</button>
                    </td>
                `;
                recipeTableBody.appendChild(row);
            });
        }

        // Edit a recipe
        function editRecipe(id) {
            const recipe = recipes.find(r => r.id === id);
            if (recipe) {
                document.getElementById('title').value = recipe.title;
                document.getElementById('origin').value = recipe.origin;
                document.getElementById('ingredients').value = recipe.ingredients;
                document.getElementById('nutritionalValue').value = recipe.nutritionalValue;
                document.getElementById('allergenInfo').value = recipe.allergenInfo;
                document.getElementById('shelfLife').value = recipe.shelfLife;
                document.getElementById('quantity').value = recipe.quantity;
                document.getElementById('unit').value = recipe.unit;
                document.getElementById('prepTime').value = recipe.prepTime;
                document.getElementById('cookTime').value = recipe.cookTime;
                document.getElementById('servingSize').value = recipe.servingSize;
                document.getElementById('foodDescription').value = recipe.foodDescription;
                document.getElementById('calories').value = recipe.calories;
                document.getElementById('foodOrigin').value = recipe.foodOrigin;
                document.getElementById('instructions').value = recipe.instructions;

                isEditing = true;
                currentRecipeId = recipe.id;
                window.scrollTo(0, 0); // Scroll to the top to see the form
            }
        }

        // Close recipe details section
        closeDetailsBtn.addEventListener('click', function() {
            recipeDetails.classList.add('hidden');
        });

        // Reset the form
        function resetForm() {
            recipeForm.reset();
            isEditing = false;
            currentRecipeId = null;
        }
    </script>
</body>
</html>
