<?php
session_start();
require_once 'config.php'; // Database configuration
require_once 'user_management_function.php'; // Utility functions like isSuperAdmin(), getAllUsers(), updateUserStatus(), etc.

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the user's role
$userRole = $_SESSION['role'];

// Fetch data based on role
if ($userRole === 'Super Admin') {
    // Super Admin dashboard content
    $usersCount = getTotalUsers();
    $recipesCount = getTotalRecipes();
    $pendingApprovals = getPendingApprovals();
    $users = getAllUsers();
    $recipes = getAllRecipes(); // Recent recipes
    
    // Fetching system-wide statistics (optional)
    $userTrends = getUserRegistrationTrends(); // Could be used for charts
    $recipeTrends = getRecipeSubmissionTrends(); // Could be used for charts
} else {
    // Regular Admin dashboard content
    $userId = $_SESSION['user_id'];
    $adminRecipesCount = getAdminRecipesCount($userId);
    $adminRecipes = getAdminRecipes($userId); // Recent admin's recipes
    $recipeTrends = getPersonalRecipeTrends($userId); // Optional personal trends chart
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php if ($userRole === 'Super Admin'): ?>
    <h1>Super Admin Dashboard</h1>
    <!-- Analytics Section -->
    <div>
        <h2>Analytics</h2>
        <p>Total Users: <?php echo $usersCount; ?></p>
        <p>Total Recipes: <?php echo $recipesCount; ?></p>
        <p>Pending User Approvals: <?php echo $pendingApprovals; ?></p>
    </div>
    
    <!-- User Management Section -->
    <div>
        <h2>User Management</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><?php echo $user['role']; ?></td>
                        <td><?php echo $user['status']; ?></td>
                        <td>
                            <!-- Add Approve/Reject and Delete Buttons -->
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Recipe Overview Section -->
    <div>
        <h2>Recipe Overview</h2>
        <table>
            <thead>
                <tr>
                    <th>Recipe Title</th>
                    <th>User</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recipes as $recipe): ?>
                    <tr>
                        <td><?php echo $recipe['title']; ?></td>
                        <td><?php echo $recipe['user_id']; ?></td>
                        <td><?php echo $recipe['status']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

<?php else: ?>
    <h1>Admin Dashboard</h1>
    <!-- Personal Analytics Section -->
    <div>
        <h2>Personal Analytics</h2>
        <p>Total Recipes: <?php echo $adminRecipesCount; ?></p>
    </div>

    <!-- Recipe Management Section -->
    <div>
        <h2>Your Recipes</h2>
        <table>
            <thead>
                <tr>
                    <th>Recipe Title</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($adminRecipes as $recipe): ?>
                    <tr>
                        <td><?php echo $recipe['title']; ?></td>
                        <td><?php echo $recipe['status']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

</body>
</html>
