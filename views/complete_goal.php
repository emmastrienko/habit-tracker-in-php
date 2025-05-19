<?php
require_once './config/db.php';

$user_id = $_SESSION['user_id'] ?? null;
$goal_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if (!$user_id || !$goal_id) {
    die("Invalid request.");
}

// Check if the goal belongs to the current user (security check)
$stmt = $conn->prepare("SELECT * FROM goals WHERE id = :id AND user_id = :user_id");
$stmt->execute(['id' => $goal_id, 'user_id' => $user_id]);
$goal = $stmt->fetch();

if (!$goal) {
    die("Goal not found or not authorized.");
}

// Mark the goal as completed
$update = $conn->prepare("UPDATE goals SET completed = 1 WHERE id = :id");
$update->execute(['id' => $goal_id]);

// Redirect back to the list of goals
header("Location: index.php?action=goals");  // Change this to the correct page
exit;
