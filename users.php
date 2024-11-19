<?php 

include 'config.php';
include 'user_actions.php';

// Check if user is logged in and has Super Admin role
if (!isset($_SESSION['user_id']) || get_user_role($_SESSION['user_id']) != 1) {
    header('Location: login.php');
    exit();
}

// Function to get all users
function get_all_users() {
    global $conn; // Assuming you're using a MySQL connection stored in $conn

    $sql = "SELECT * FROM users";  // Adjust this query according to your database schema
    $result = $conn->query($sql);

    $users = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }
    return $users;
}

$users = get_all_users();  // Fetch all users from the database
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
    <title>User Management System</title>
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

        <h1>User Management System</h1>
        <!-- Content Section -->
        <div class="content">
            <table id="userTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fisrt Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Role</th>
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
                        <td>
                            <button onclick="viewUser(<?php echo $user['user_id']; ?>)">View</button>
                            <button onclick="editUser(<?php echo $user['user_id']; ?>, '<?php echo htmlspecialchars($user['fname']); ?>', '<?php echo htmlspecialchars($user['email']); ?>')">Edit</button>
                            <button onclick="confirmDeleteUser(<?php echo $user['user_id']; ?>)">Delete</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Pagination Controls -->
            <div class="pagination">
                <a href="?page=1">&laquo; First</a>
                <a href="?page=<?php echo max(1, $page - 1); ?>">Previous</a>
                <a href="?page=<?php echo min($total_pages, $page + 1); ?>">Next</a>
                <a href="?page=<?php echo $total_pages; ?>">Last &raquo;</a>
            </div>

            <h2>Add User</h2>
            <form id="userForm" onsubmit="return validateForm()"> <!-- Attach validateForm function -->
                <input type="text" id="name" placeholder="Name" required>
                <input type="email" id="email" placeholder="Email" required>
                <select id="role">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
                <button type="submit">Add User</button>
            </form>

            <div id="userDetails" class="hidden">
                <h2>User Details</h2>
                <p><strong>ID:</strong> <span id="detailId"></span></p>
                <p><strong>Name:</strong> <span id="detailName"></span></p>
                <p><strong>Email:</strong> <span id="detailEmail"></span></p>
                <p><strong>Role:</strong> <span id="detailRole"></span></p>
                <button id="closeDetails">Close</button>
            </div>
        </div>

        <!-- Footer Section -->
        <footer class="footer">
            <p>&copy; 2024 Recipe Sharing Platform. All Rights Reserved.</p>
        </footer>
    </div>

    <script>
        function validateForm() {
            const name = document.getElementById("name").value;
            const email = document.getElementById("email").value;
            if (name.trim() === "" || email.trim() === "") {
                alert("Name and Email are required!");
                return false;
            }
            return true;
        }

        function viewUser(id) {
            // Fetch and display user details
        }

        function editUser(id, name, email) {
            document.getElementById("name").value = name;
            document.getElementById("email").value = email;
            document.getElementById("role").value = "user";  // Or fetch the actual role
        }

        function confirmDeleteUser(id) {
            const userConfirmed = confirm("Are you sure you want to delete this user?");
            if (userConfirmed) {
                deleteUser(id);
            }
        }

        function deleteUser(id) {
            fetch('user_action.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ action: 'delete', id: id })
            })
            .then(response => response.json())
            .then(result => {
                if (result.status === 'success') {
                    alert("User deleted successfully");
                    location.reload();  // Reload the page to reflect changes
                } else {
                    alert(result.message);
                }
            })
            .catch(error => {
                alert("Error: " + error);
            });
        }
    </script>
</body>
</html>
