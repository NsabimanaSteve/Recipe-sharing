<?php
// functions.php

function isAdmin() {
    return $_SESSION['role'] === 'Admin' || $_SESSION['role'] === 'Super Admin';
}

function getAllRecipes() {
    global $db;
    $stmt = $db->prepare("SELECT id, name, category, ingredients, created_date FROM recipes ORDER BY created_date DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function searchRecipes($searchQuery) {
    global $db;
    $stmt = $db->prepare("SELECT id, name, category, ingredients, created_date FROM recipes WHERE name LIKE ? ORDER BY created_date DESC");
    $stmt->execute(["%$searchQuery%"]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getRecipesByCategory($category) {
    global $db;
    $stmt = $db->prepare("SELECT id, name, category, ingredients, created_date FROM recipes WHERE category = ? ORDER BY created_date DESC");
    $stmt->execute([$category]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function deleteRecipe($recipeId) {
    global $db;
    $stmt = $db->prepare("DELETE FROM recipes WHERE id = ?");
    $stmt->execute([$recipeId]);
}
?>
