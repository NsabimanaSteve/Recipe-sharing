<?php
// Database connection
include 'db_connection.php';

// Check for action (e.g., add, edit, delete, search)
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'add') {
        // Retrieve recipe data from POST request
        $title = $_POST['title'];
        $ingredients = $_POST['ingredients'];
        // ... other recipe fields

        // Insert recipe into database
        $sql = "INSERT INTO recipes (title, origin, ingredients, nutritional_value, allergen_info, shelf_life, quantity, unit, prep_time, cook_time, serving_size, food_description, calories, food_origin, instructions) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssisssiisss", $title, $origin, $ingredients, $nutritionalValue, $allergenInfo, $shelfLife, $quantity, $unit, $prepTime, $cookTime, $servingSize, $foodDescription, $calories, $foodOrigin, $instructions);
        $stmt->execute();

        // Redirect to a success page or display a success message
    } elseif ($action === 'edit') {
        // ... similar logic for editing recipes
    } elseif ($action === 'delete') {
        // ... similar logic for deleting recipes
    } elseif ($action === 'search') {
        // ... similar logic for searching recipes
    }
} else {
    // Handle invalid requests or errors
}

$conn->close();