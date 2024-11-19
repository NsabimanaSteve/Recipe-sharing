<?php
include 'config.php'; // Database connection

// Function to get user role
function get_user_role($user_id) {
    global $conn;
    $query = "SELECT role FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($role);
    $stmt->fetch();
    return $role;
}

// Function to get total users
function get_total_users() {
    global $conn;
    $query = "SELECT COUNT(*) FROM users";
    $result = $conn->query($query);
    $row = $result->fetch_row();
    return $row[0];
}

// Function to get total recipes
function get_total_recipes() {
    global $conn;
    $query = "SELECT COUNT(*) FROM foods";
    $result = $conn->query($query);
    $row = $result->fetch_row();
    return $row[0];
}

// Function to get pending user approvals
function get_pending_user_approvals() {
    global $conn;
    $query = "SELECT COUNT(*) FROM users WHERE role = 0"; // Assuming 0 is for pending approvals
    $result = $conn->query($query);
    $row = $result->fetch_row();
    return $row[0];
}

// Function to fetch all users (for Super Admin)

function get_all_users() {
    global $conn; // Use the global $conn for the DB connection

    // Prepare SQL query to fetch all users
    $query = "SELECT user_id, fname, lname, email, role, created_at, updated_at FROM users";
    $result = $conn->query($query);

    // Check if the query is successful
    if ($result === false) {
        die("Query failed: " . $conn->error);
    }

    $users = [];

    // Fetch each row and store it in the $users array
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    return $users; // Return the array of users
}



function get_admin_recipe_trends($user_id) {
    global $conn; // Use the global mysqli connection
    if (!$conn) {
        die("Database connection is not initialized.");
    }
    $query = "SELECT MONTH(created_at) AS month, COUNT(*) AS recipes_count
              FROM recipes 
              WHERE recipe_id = ?
              GROUP BY MONTH(created_at)";

    // Prepare the statement
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Failed to prepare statement: " . $conn->error);
    }

    // Bind the parameter and execute the query
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    // Fetch the results
    $result = $stmt->get_result();
    $trends = [];
    while ($row = $result->fetch_assoc()) {
        $trends[] = $row;
    }

    // Free resources and return the data
    $stmt->close();
    return $trends;
}

// Function to fetch recent recipes (for Super Admin)
function get_recent_recipes() {
    global $conn; // Assuming you have a database connection $conn
    
    $sql = "SELECT * FROM recipes ORDER BY created_at DESC LIMIT 5"; // Example query to get recent recipes
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        // Fetch all rows as an associative array
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        return []; // Return an empty array if there's an error
    }
}


// Function to get recipes for an admin
function get_total_admin_recipes($user_id) {
    global $conn;
    $query = "SELECT COUNT(*) FROM foods WHERE created_by = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    return $count;
}


function get_admin_recipes($user_id) {
    global $conn; 
    if (!$conn) {
        die("Database connection is not initialized.");
    }

    $query = "SELECT  food_id,ingredient_id,unit, created_at FROM recipes WHERE recipe_id = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("Failed to prepare statement: " . $conn->error);
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $recipes = [];

    while ($row = $result->fetch_assoc()) {
        $recipes[] = $row;
    }

    $stmt->close();

    return $recipes;
}


?>
