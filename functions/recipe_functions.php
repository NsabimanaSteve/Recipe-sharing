<?php

function createRecipe($pdo, $name, $origin, $type, $is_healthy, $instructions, $description, $preparation_time, $cooking_time, $serving_size, $calories_per_serving, $image_url, $created_by, $is_approved) {
    // Prepare and execute the SQL query
    $sql = "INSERT INTO foods (name, origin, type, is_healthy, instructions, description, preparation_time, cooking_time, serving_size, calories_per_serving, image_url, created_by, is_approved) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([$name, $origin, $type, $is_healthy, $instructions, $description, $preparation_time, $cooking_time, $serving_size, $calories_per_serving, $image_url, $created_by, $is_approved]);
        return true; // Recipe created successfully
    } catch (PDOException $e) {
        // Handle error, e.g., log the error or display an error message
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function getRecipes($pdo, $filters = []) {
    // Build the SQL query based on filters
    $sql = "SELECT * FROM foods";
    $where_clause = [];
    $params = [];
    if (!empty($filters)) {
        foreach ($filters as $key => $value) {
            $where_clause[] = "$key = ?";
            $params[] = $value;
        }
        $sql .= " WHERE " . implode(" AND ", $where_clause);
    }

    // Prepare and execute the query
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getRecipeById($pdo, $recipeId) {
    // Prepare and execute the SQL query
    $sql = "SELECT * FROM foods WHERE food_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$recipeId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateRecipe($pdo, $recipeId, $updatedData) {
    // Prepare and execute the SQL query to update the recipe
    $sql = "UPDATE foods SET ";
    $params = [];
    $i = 1;
    foreach ($updatedData as $key => $value) {
        $sql .= "$key = ?, ";
        $params[] = $value;
        $i++;
    }
    $sql = rtrim($sql, ", ");
    $sql .= " WHERE food_id = ?";
    $params[] = $recipeId;

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
}