<?php

function addUser($pdo, $name, $email, $password) {
    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute the SQL query to add a new user
    $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $email, $hashedPassword]);
}

function getUserById($pdo, $userId) {
    // Prepare and execute the SQL query to retrieve a user by ID
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getAllUsers($pdo) {
    // Prepare and execute the SQL query to retrieve all users
    $sql = "SELECT * FROM users";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updateUser($pdo, $userId, $name, $email, $password = null) {
    // Prepare and execute the SQL query to update a user
    $sql = "UPDATE users SET name = ?, email = ?";
    $params = [$name, $email];

    if ($password) {
        $sql .= ", password = ?";
        $params[] = password_hash($password, PASSWORD_DEFAULT);
    }

    $sql .= " WHERE id = ?";
    $params[] = $userId;

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
}

function deleteUser($pdo, $userId) {
    // Prepare and execute the SQL query to delete a user
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userId]);
}