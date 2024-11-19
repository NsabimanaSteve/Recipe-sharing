<?php

function getUserById($pdo, $userId) {
    // Prepare and execute the SQL query
    $sql = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateUser($pdo, $userId, $updatedData) {
    // Prepare and execute the SQL query to update the user
    $sql = "UPDATE users SET ";
    $params = [];
    $i = 1;
    foreach ($updatedData as $key => $value) {
        $sql .= "$key = ?, ";
        $params[] = $value;
        $i++;
    }
    $sql = rtrim($sql, ", ");
    $sql .= " WHERE user_id = ?";
    $params[] = $userId;

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
}

function deleteUser($pdo, $userId) {
    // Prepare and execute the SQL query to delete the user
    $sql = "DELETE FROM users WHERE user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userId]);
}