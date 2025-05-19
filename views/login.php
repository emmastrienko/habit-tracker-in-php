<?php

// Підключення до бази даних
$host = 'localhost';
$dbname = 'habit_tracker'; 
$user = 'root';
$pass = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Помилка підключення до бази даних: " . $e->getMessage());
}

// Обробка логіну
$error = '';
$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username)) {
        $errors['username'] = "Введіть логін";
    }

    if (!$errors) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['is_admin'] = (bool)$user['admin'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Невірний логін або пароль";
        }
    }
}
?>

<!-- HTML форма логіну -->
<div class="register login">
    <h2>Login to the existing account</h2>
    <form action="" method="post">
        <label>Username: 
            <input type="text" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"> 
        </label><br>
        <span style="color:red;"> <?= $errors['username'] ?? '' ?> </span><br>
        
        <label>Password:</label>
        <div class="password-container">
            <input type="password" name="password" id="password">
            <button type="button" onclick="togglePassword('password', 'eye1')" id="eye1">🙈</button>
        </div>
        <br><br>
        <button type="submit">Login</button>
    </form>

    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
</div>


