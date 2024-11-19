<?php


session_start();
include 'config.php'; // Database connection
include 'dashboard_functions.php'; // Functions to fetch dashboard data


$user_id = $_SESSION['user_id'];
$user_role = get_user_role($user_id); // Fetch user role (1: Super Admin, 2: Regular Admin)

// Fetch necessary data based on role
if ($user_role == 1) {
    // Super Admin Data
    $usersCount = get_total_users();
    $recipesCount = get_total_recipes();
    $pendingApprovals = get_pending_user_approvals();
    $users = get_all_users(); // Fetch users for Super Admin dashboard
    $recipes = get_recent_recipes(); // Fetch recent recipes for Super Admin
} elseif ($user_role == 2) {
    // Regular Admin Data
    $adminRecipesCount = get_total_admin_recipes($user_id);
    $adminRecipes = get_admin_recipes($user_id);
    $recipeTrends = get_admin_recipe_trends($user_id); // Monthly trends (e.g., array of month-wise recipe submission counts)
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
    <header>
        <h1><?php echo $user_role == 1 ? 'Super Admin Dashboard' : 'Admin Dashboard'; ?></h1>
    </header>

    <?php if ($user_role == 1): ?> <!-- Super Admin Dashboard -->
        <section>
            <h2>Analytics</h2>
            <p>Total Users: <?php echo $usersCount; ?></p>
            <p>Total Recipes: <?php echo $recipesCount; ?></p>
            <p>Pending User Approvals: <?php echo $pendingApprovals; ?></p>
        </section>

        <section>
            <h2>User Management</h2>

            <?php
            // Fetch users from the database
            if (is_array($users) && !empty($users)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fisrt Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Createed Date</th>
                            <th>Updated Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                                <td><?php echo htmlspecialchars($user['fname']); ?></td>
                                <td><?php echo htmlspecialchars($user['lname']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo htmlspecialchars($user['role']); ?></td>
                                <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                                <td><?php echo htmlspecialchars($user['updated_at']); ?></td>
                                <td>
                                    <form action="user_management_actions.php" method="post">
                                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['user_id']); ?>">
                                        <button type="submit" name="approve" style="background-color: green;">Approve</button>
                                        <button type="submit" name="reject" style="background-color: orange;">Reject</button>
                                        <button type="submit" name="delete" style="background-color: red;">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No users found.</p>
            <?php endif; ?>
        </section>

        <section>
            <h2>Recipe Overview</h2>
            <?php
            // Fetch the recent recipes from the database
            if (is_array($recipes) && !empty($recipes)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Recipe Title</th>
                            <th>Submitted By</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recipes as $recipe): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($recipe['title']); ?></td>
                                <td><?php echo htmlspecialchars($recipe['user_id']); ?></td>
                                <td><?php echo htmlspecialchars($recipe['status']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No recent recipes found.</p>
            <?php endif; ?>
        </section>
    <?php elseif ($user_role == 2): ?> <!-- Regular Admin Dashboard -->
        <section>
            <h2>Personal Analytics</h2>
            <p>Total Recipes: <?php echo $adminRecipesCount; ?></p>
        </section>

        <section>
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
                            <td><?php echo htmlspecialchars($recipe['title']); ?></td>
                            <td><?php echo htmlspecialchars($recipe['status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <section>
            <h2>Recipe Submission Trends</h2>
            <table>
                <thead>
                    <tr>
                        <th>Month</th>
                        <th>Recipes Submitted</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recipeTrends as $trend): ?>
                        <tr>
                            <td><?php echo date('F', mktime(0, 0, 0, $trend['month'], 10)); ?></td>
                            <td><?php echo $trend['recipes_count']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    <?php endif; ?>

</body>
</html>
