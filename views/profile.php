<?php
session_start();
require_once './config/db.php';

if (empty($_SESSION['user_id'])) {
    header("Location: index.php?action=login");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT username, email, first_name, last_name, birthdate FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "Користувача не знайдено";
    exit;
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8" />
    <title>Профіль користувача</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }
        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
        }
        ul {
            max-width: 400px;
            margin: 0 auto 30px auto;
            padding: 0;
            list-style: none;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
        }
        ul li {
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
            font-size: 1.1em;
        }
        ul li:last-child {
            border-bottom: none;
        }
        ul li b {
            color: #2980b9;
            width: 120px;
            display: inline-block;
        }
        a {
            display: block;
            width: 160px;
            margin: 0 auto;
            margin-bottom: 130px;
            text-align: center;
            background: #2980b9;
            color: white;
            text-decoration: none;
            padding: 12px 0;
            border-radius: 6px;
            font-weight: 600;
            box-shadow: 0 4px 8px rgba(41,128,185,0.3);
            transition: background-color 0.3s ease;
        }
        a:hover {
            background: #1f6391;
            box-shadow: 0 6px 14px rgba(31,99,145,0.5);
        }
    </style>
</head>
<body>

<h2>Профіль користувача</h2>
<ul>
    <li><b>Логін:</b> <?= htmlspecialchars($user['username']) ?></li>
    <li><b>Email:</b> <?= htmlspecialchars($user['email']) ?></li>
    <li><b>Ім’я:</b> <?= htmlspecialchars($user['first_name']) ?></li>
    <li><b>Прізвище:</b> <?= htmlspecialchars($user['last_name']) ?></li>
    <li><b>Дата народження:</b> <?= htmlspecialchars($user['birthdate']) ?></li>
</ul>

<a href="index.php?action=edit_profile">Редагувати профіль</a>

</body>
</html>
