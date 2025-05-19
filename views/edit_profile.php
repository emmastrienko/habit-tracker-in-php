<?php
session_start();
require_once './config/db.php';

if (empty($_SESSION['user_id'])) {
    header("Location: index.php?action=login");
    exit;
}

$user_id = $_SESSION['user_id'];

// Отримуємо дані користувача
$stmt = $conn->prepare("SELECT username, email, first_name, last_name, birthdate FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "Користувача не знайдено";
    exit;
}

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $birthdate = $_POST['birthdate'] ?? '';
    $email = trim($_POST['email'] ?? '');

    $old_password = $_POST['old_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Перевірка даних
    if (!$first_name || !$last_name || !$birthdate || !$email) {
        $errors[] = "Заповніть всі поля, окрім паролів.";
    }

    // Перевірка пароля (якщо хочуть змінити)
    if ($old_password || $new_password || $confirm_password) {
        // Отримуємо пароль з БД
        $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $db_user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$db_user || !password_verify($old_password, $db_user['password'])) {
            $errors[] = "Старий пароль введено невірно.";
        } elseif ($new_password !== $confirm_password) {
            $errors[] = "Новий пароль та підтвердження не співпадають.";
        } elseif (empty($new_password)) {
            $errors[] = "Новий пароль не може бути порожнім.";
        }
    }

    if (empty($errors)) {
        // Оновлення профілю
        $update_sql = "UPDATE users SET first_name = ?, last_name = ?, birthdate = ?, email = ? WHERE id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->execute([$first_name, $last_name, $birthdate, $email, $user_id]);

        // Оновлення пароля, якщо потрібно
        if ($old_password && $new_password && $new_password === $confirm_password) {
            $new_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->execute([$new_hash, $user_id]);
        }

        $success = true;

        // Оновлюємо локальні дані користувача
        $user['first_name'] = $first_name;
        $user['last_name'] = $last_name;
        $user['birthdate'] = $birthdate;
        $user['email'] = $email;
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8" />
    <title>Редагування профілю</title>
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
        form {
            max-width: 480px;
            margin: 0 auto;
            background: white;
            padding: 30px 25px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        label {
            font-weight: 600;
            display: block;
            margin-top: 15px;
            margin-bottom: 6px;
            color: #34495e;
        }
        input[type="text"],
        input[type="email"],
        input[type="date"],
        input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-family: inherit;
        }
        button[type="submit"] {
            margin-top: 25px;
            background-color: #2980b9;
            color: white;
            border: none;
            padding: 12px 0;
            width: 100%;
            font-size: 1.1rem;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 700;
            transition: background-color 0.3s ease;
        }
        button[type="submit"]:hover {
            background-color: #1f6391;
        }
        .message {
            max-width: 480px;
            margin: 20px auto 0 auto;
            padding: 15px 20px;
            border-radius: 6px;
            font-weight: 600;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        small {
            display: block;
            margin-top: 4px;
            color: #7f8c8d;
        }
    </style>
</head>
<body>

<h2>Редагування профілю</h2>

<?php if ($errors): ?>
    <div class="message error">
        <?php foreach ($errors as $error): ?>
            <div><?= htmlspecialchars($error) ?></div>
        <?php endforeach; ?>
    </div>
<?php elseif ($success): ?>
    <div class="message success">Профіль успішно оновлено!</div>
<?php endif; ?>

<form method="post" novalidate>
    <label for="first_name">Ім’я:</label>
    <input type="text" id="first_name" name="first_name" required value="<?= htmlspecialchars($user['first_name']) ?>">

    <label for="last_name">Прізвище:</label>
    <input type="text" id="last_name" name="last_name" required value="<?= htmlspecialchars($user['last_name']) ?>">

    <label for="birthdate">Дата народження:</label>
    <input type="date" id="birthdate" name="birthdate" required value="<?= htmlspecialchars($user['birthdate']) ?>">

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required value="<?= htmlspecialchars($user['email']) ?>">

    <hr style="margin: 30px 0; border: none; border-top: 1px solid #eee;">

    <label for="old_password">Старий пароль:</label>
    <input type="password" id="old_password" name="old_password" placeholder="Якщо хочеш змінити пароль">

    <label for="new_password">Новий пароль:</label>
    <input type="password" id="new_password" name="new_password" placeholder="Новий пароль">

    <label for="confirm_password">Повторіть пароль:</label>
    <input type="password" id="confirm_password" name="confirm_password" placeholder="Повторіть новий пароль">

    <button type="submit">Зберегти зміни</button>
</form>

</body>
</html>
