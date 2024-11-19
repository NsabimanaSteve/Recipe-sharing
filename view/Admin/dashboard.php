<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Recipe Dashboard</title>
    <link rel="stylesheet" href="stylesc.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <h1>Food Recipe Dashboard</h1>
            <nav class="navbar">
                <a href="index.html">Home</a>
                <a href="login.html">Login</a>
                <a href="register.html">Sign Up</a>
                <a href="dashboard.html">Dashboard</a>
                <a href="Recipes.html">Recipe Management</a>
                <a href="users.html">User Management</a>
                <a href="logout.php">Logout</a>
                
            </nav>
        </header>

        <main>
            <section class="analytics">
                <div class="analytics-info">
                    <div class="analytics-item">
                        <p>Total Users</p>
                        <h2 id="total-users">120</h2>
                    </div>
                    <div class="analytics-item">
                        <p>Total Recipes</p>
                        <h2 id="total-recipes">450</h2>
                    </div>
                </div>

                <div class="chart-container">
                    <h2>Recipes Created per Month</h2>
                    <div class="chart">
                        <!-- <div class="y-axis">
                            <span>60</span>
                            <span>50</span>
                            <span>40</span>
                            <span>30</span>
                            <span>20</span>
                            <span>10</span>
                            <span>0</span>
                        </div> -->
                        <div class="bar" style="height: 10%;"></div>
                        <div class="bar" style="height: 20%;"></div>
                        <div class="bar" style="height: 30%;"></div>
                        <div class="bar" style="height: 40%;"></div>
                        <div class="bar" style="height: 50%;"></div>
                        <div class="bar" style="height: 60%;"></div>
                    </div>
                    <div class="month-labels">
                        <span>Jan</span>
                        <span>Feb</span>
                        <span>Mar</span>
                        <span>Apr</span>
                        <span>May</span>
                        <span>Jun</span>
                    </div>
                </div>

                <div class="top-users">
                    <h2>Top 5 Most Active Users</h2>
                    <ol id="top-users-list">
                        <li>Eddy Kubwimana - 20 Recipes</li>
                        <li>Gaga Igirukwishaka - 18 Recipes</li>
                        <li>Etiene Ndayi - 15 Recipes</li>
                        <li>Cyntia Mahoro - 14 Recipes</li>
                        <li>Nadage Uwineza - 12 Recipes</li>
                    </ol>
                </div>
            </section>
        </main>

        <footer class="footer">
            <p>&copy; 2024 Recipe Sharing Platform. All Rights Reserved.</p>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const recipesPerMonth = [10, 20, 30, 40, 50, 60];
            const bars = document.querySelectorAll('.bar');
            bars.forEach((bar, index) => {
                const maxHeight = 200;
                const heightPercentage = (recipesPerMonth[index] / 60) * maxHeight;
                bar.style.height = `${heightPercentage}px`;
            });

            const totalUsers = 120;
            const totalRecipes = 450;
            document.getElementById('total-users').textContent = totalUsers;
            document.getElementById('total-recipes').textContent = totalRecipes;

            
            topUsers.forEach(user => {
                const li = document.createElement('li');
                li.textContent = `${user.name} - ${user.recipes} Recipes`;
                topUsersList.appendChild(li);
            });
        });
    </script>
</body>
</html>
