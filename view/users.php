<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesc.css"> <!-- Link to your CSS file -->
    <title>User Management System</title>
</head>
<body>
    <div class="container">
        <!-- Header Section -->
        <header class="header">
            <h1>Food Recipe Dashboard</h1>
            <nav class="navbar">
                <a href="index.html">Home</a>
                <a href="login.html">Login</a>
                <a href="register.html">Sign Up</a>
                <a href="dashboard.html">Dashboard</a>
                <a href="Recipes.html">Recipe Management</a>
                <a href="users.html">User Management</a>
            </nav>
        </header>

        <h1>User Management System</h1>
        <!-- Content Section -->
        <div class="content">
            <table id="userTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // PHP code to fetch and display user data from the database
                    include 'db_connect.php';

                    $sql = "SELECT * FROM users";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>
                                    <button onclick=\"viewUser(" . $row['id'] . ", '" . $row['name'] . "', '" . $row['email'] . "')\">View</button>
                                    <button onclick=\"editUser(" . $row['id'] . ", '" . $row['name'] . "', '" . $row['email'] . "')\">Edit</button>
                                    <button onclick=\"confirmDeleteUser(" . $row['id'] . ")\">Delete</button>
                                </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No users found</td></tr>";
                    }
                    ?>
                    <!-- User rows will be populated here -->
                </tbody>
            </table>

            <h2>Add User</h2>
            <form id="userForm" onsubmit="return validateForm()"> <!-- Attach validateForm function -->
                <input type="text" id="name" placeholder="Name" required>
                <input type="email" id="email" placeholder="Email" required>
                <button type="submit">Add User</button>
            </form>

            <div id="userDetails" class="hidden">
                <h2>User Details</h2>
                <p><strong>ID:</strong> <span id="detailId"></span></p>
                <p><strong>Name:</strong> <span id="detailName"></span></p>
                <p><strong>Email:</strong> <span id="detailEmail"></span></p>
                <button id="closeDetails">Close</button>
            </div>
        </div>

        <!-- Footer Section -->
        <footer class="footer">
            <p>&copy; 2024 Recipe Sharing Platform. All Rights Reserved.</p>
        </footer>
    </div>

    <script>
        let userIdCounter = 1;
        const userTable = document.getElementById("userTable").getElementsByTagName("tbody")[0];
        const userForm = document.getElementById("userForm");
        const userDetails = document.getElementById("userDetails");
        const detailId = document.getElementById("detailId");
        const detailName = document.getElementById("detailName");
        const detailEmail = document.getElementById("detailEmail");
        const closeDetails = document.getElementById("closeDetails");

        userForm.addEventListener("submit", function (event) {
            event.preventDefault();
            if (validateForm()) {
                addOrUpdateUser();
            }
        });

        function addOrUpdateUser() {
            const name = document.getElementById("name").value;
            const email = document.getElementById("email").value;
            const editId = userForm.getAttribute("data-edit-id");

            if (editId) {
                // Update existing user
                const rows = userTable.rows;
                for (let i = 0; i < rows.length; i++) {
                    if (rows[i].cells[0].textContent == editId) {
                        rows[i].cells[1].textContent = name;
                        rows[i].cells[2].textContent = email;
                        break;
                    }
                }
                userForm.removeAttribute("data-edit-id");
            } else {
                // Add new user
                const newRow = userTable.insertRow();
                newRow.innerHTML = 
                    `<td>${userIdCounter}</td>
                    <td>${name}</td>
                    <td>${email}</td>
                    <td>
                        <button onclick="viewUser(${userIdCounter}, '${name}', '${email}')">View</button>
                        <button onclick="editUser(${userIdCounter}, '${name}', '${email}')">Edit</button>
                        <button onclick="confirmDeleteUser(this)">Delete</button>
                    </td>`;
                userIdCounter++; // Increment userIdCounter for the next user
            }
            userForm.reset();
        }

        function viewUser(id, name, email) {
            detailId.textContent = id;
            detailName.textContent = name;
            detailEmail.textContent = email;
            userDetails.classList.remove("hidden");
        }

        function editUser(id, name, email) {
            document.getElementById("name").value = name;
            document.getElementById("email").value = email;
            userForm.setAttribute("data-edit-id", id);
        }

        function confirmDeleteUser(button) {
            const userConfirmed = confirm("Are you sure you want to delete this user?");
            if (userConfirmed) {
                deleteUser(button);
            }
        }

        function deleteUser(button) {
            const row = button.parentNode.parentNode;
            userTable.deleteRow(row.rowIndex - 1); // Adjust for header row
        }

        closeDetails.addEventListener("click", function () {
            userDetails.classList.add("hidden");
        });

        function validateForm() {
            const name = document.getElementById("name").value;
            const email = document.getElementById("email").value;

            // Regular expression for validating email format
            const emailPattern = /^[^\s@]+@[^\s@]+\.[a-zA-Z]{2,}$/;

            // Validate email format
            if (!emailPattern.test(email)) {
                alert("Please enter a valid email address.");
                return false; // Prevent form submission
            }

            // Validate name for non-empty input
            if (!name) {
                alert("Please enter a name.");
                return false; // Prevent form submission
            }

            // If validation passes, allow form submission
            return true;
        }
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST['name'];
            $email = $_POST['email'];

            // Insert user data into the database
            $sql = "INSERT INTO users (name, email) VALUES ('$name', '$email')";
            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('User added successfully!');</script>";
            } else {
                echo "<script>alert('Error adding user: " . mysqli_error($conn) . "');</script>";
            }
        }
        ?>
    </script>
</body>
</html>
