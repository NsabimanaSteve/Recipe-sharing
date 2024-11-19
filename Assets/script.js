document.addEventListener("DOMContentLoaded", function() {
    const userModal = document.getElementById('userModal');
    const recipeModal = document.getElementById('recipeModal');
    const userTableBody = document.getElementById('user-table-body');
    const recipeTableBody = document.getElementById('recipe-table-body');

    // Sample data
    let users = [
        { id: 1, name: "User 1", email: "user1@example.com" },
        { id: 2, name: "User 2", email: "user2@example.com" }
    ];

    let recipes = [
        { id: 1, name: "Recipe 1", description: "Delicious Recipe 1" },
        { id: 2, name: "Recipe 2", description: "Delicious Recipe 2" }
    ];

    // Function to render users in the table
    function renderUsers() {
        userTableBody.innerHTML = '';
        users.forEach(user => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${user.id}</td>
                <td>${user.name}</td>
                <td>${user.email}</td>
                <td>
                    <button onclick="openUserModal(${user.id})">Edit</button>
                    <button onclick="confirmDeleteUser(${user.id})">Delete</button>
                </td>
            `;
            userTableBody.appendChild(row);
        });
    }

    // Function to render recipes in the table
    function renderRecipes() {
        recipeTableBody.innerHTML = '';
        recipes.forEach(recipe => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${recipe.id}</td>
                <td>${recipe.name}</td>
                <td>${recipe.description}</td>
                <td>
                    <button onclick="openRecipeModal(${recipe.id})">Edit</button>
                    <button onclick="confirmDeleteRecipe(${recipe.id})">Delete</button>
                </td>
            `;
            recipeTableBody.appendChild(row);
        });
    }

    // Handle adding a user
    document.getElementById('add-user-form').onsubmit = function(event) {
        event.preventDefault();
        const userName = document.getElementById('user-name').value;
        const userEmail = document.getElementById('user-email').value;
        const newUser = {
            id: users.length + 1,
            name: userName,
            email: userEmail
        };
        users.push(newUser);
        renderUsers();
        this.reset();
    };

    // Handle editing a user
    document.getElementById('edit-user-form').onsubmit = function(event) {
        event.preventDefault();
        const userId = document.getElementById('edit-user-id').value;
        const userName = document.getElementById('edit-user-name').value;
        const userEmail = document.getElementById('edit-user-email').value;

        const user = users.find(user => user.id == userId);
        user.name = userName;
        user.email = userEmail;

        renderUsers();
        userModal.style.display = "none";
    };

    // Open user modal for editing
    window.openUserModal = function(id) {
        const user = users.find(user => user.id === id);
        document.getElementById('edit-user-id').value = user.id;
        document.getElementById('edit-user-name').value = user.name;
        document.getElementById('edit-user-email').value = user.email;
        userModal.style.display = "block";
    };

    // Confirm delete user
    window.confirmDeleteUser = function(id) {
        users = users.filter(user => user.id !== id);
        renderUsers();
    };

    // Handle adding a recipe
    document.getElementById('add-recipe-form').onsubmit = function(event) {
        event.preventDefault();
        const recipeName = document.getElementById('recipe-name').value;
        const recipeDescription = document.getElementById('recipe-description').value;
        const newRecipe = {
            id: recipes.length + 1,
            name: recipeName,
            description: recipeDescription
        };
        recipes.push(newRecipe);
        renderRecipes();
        this.reset();
    };

    // Handle editing a recipe
    document.getElementById('edit-recipe-form').onsubmit = function(event) {
        event.preventDefault();
        const recipeId = document.getElementById('edit-recipe-id').value;
        const recipeName = document.getElementById('edit-recipe-name').value;
        const recipeDescription = document.getElementById('edit-recipe-description').value;

        const recipe = recipes.find(recipe => recipe.id == recipeId);
        recipe.name = recipeName;
        recipe.description = recipeDescription;

        renderRecipes();
        recipeModal.style.display = "none";
    };

    // Open recipe modal for editing
    window.openRecipeModal = function(id) {
        const recipe = recipes.find(recipe => recipe.id === id);
        document.getElementById('edit-recipe-id').value = recipe.id;
        document.getElementById('edit-recipe-name').value = recipe.name;
        document.getElementById('edit-recipe-description').value = recipe.description;
        recipeModal.style.display = "block";
    };

    // Confirm delete recipe
    window.confirmDeleteRecipe = function(id) {
        recipes = recipes.filter(recipe => recipe.id !== id);
        renderRecipes();
    };

    // Close modal when clicking on (x)
    const closeModal = function(modal) {
        modal.style.display = "none";
    };

    // Close user modal
    userModal.querySelector('.close').onclick = function() {
        closeModal(userModal);
    };

    // Close recipe modal
    recipeModal.querySelector('.close').onclick = function() {
        closeModal(recipeModal);
    };

    // Close modal when clicking outside of it
    window.onclick = function(event) {
        if (event.target === userModal) {
            closeModal(userModal);
        }
        if (event.target === recipeModal) {
            closeModal(recipeModal);
        }
    };

    // Chart.js to display analytics
    const ctx = document.getElementById('recipesChart').getContext('2d');
    const recipesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Recipe 1', 'Recipe 2', 'Recipe 3', 'Recipe 4', 'Recipe 5'],
            datasets: [{
                label: '# of Users per Recipe',
                data: [12, 19, 3, 5, 2], // Example data
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Initial render
    renderUsers();
    renderRecipes();
});
