<?php
session_start();
require_once __DIR__ . '/../config/db.php'; // виправлений шлях

$user_id = $_SESSION['user_id'] ?? null;
$goal_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if (!$user_id || !$goal_id) {
    die("Invalid request.");
}

// Перевіряємо, чи ціль належить користувачу
$stmt = $conn->prepare("SELECT * FROM goals WHERE id = :id AND user_id = :user_id");
$stmt->execute(['id' => $goal_id, 'user_id' => $user_id]);
$goal = $stmt->fetch();

if (!$goal) {
    die("Goal not found or not authorized.");
}

// Видаляємо ціль
$delete = $conn->prepare("DELETE FROM goals WHERE id = :id");
$delete->execute(['id' => $goal_id]);

// Повертаємось до сторінки зі списком цілей
header("Location: index.php?action=goals");
exit;
