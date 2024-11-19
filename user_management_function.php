<?php
// functions.php
include("config.php");
function isSuperAdmin() {
    return $_SESSION['role'] === 'Super Admin';
}

function getAllUsers() {
    global $db;
    $stmt = $db->prepare("SELECT user_id, fname,lname, email, role, create_at FROM users ORDER BY id DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updateUsercreate_at($user_id, $create_at) {
    global $db;
    $stmt = $db->prepare("UPDATE users SET create_at = ? WHERE id = ?");
    $stmt->execute([$create_at, $user_id]);
}

function updateUserRole($user_id, $role) {
    global $db;
    $stmt = $db->prepare("UPDATE users SET role = ? WHERE id = ?");
    $stmt->execute([$role, $user_id]);
}

function deleteUser($user_id) {
    global $db;
    $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
}
?>
