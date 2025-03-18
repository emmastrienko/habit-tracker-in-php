<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];
    
    // Validate username
    $login = $_POST['login'] ?? '';
    if (!preg_match('/^[a-zA-Zа-яА-ЯёЁ0-9_-]{4,}$/u', $login)) {
        $errors['login'] = "Username must be at least 4 characters long and can include only letters, numbers, '_', and '-'.";
    }
    
    // Validate password
    $password = $_POST['password'] ?? '';
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{7,}$/', $password)) {
        $errors['password'] = "Password must be at least 7 characters long, contain uppercase and lowercase letters, and at least one number.";
    }
    
    // Validate password confirmation
    $repeat_password = $_POST['repeat_password'] ?? '';
    if ($password !== $repeat_password) {
        $errors['repeat_password'] = "Passwords do not match.";
    }
    
    // Validate email
    $email = $_POST['email'] ?? '';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    }
    
    // Validate website
    $website = $_POST['website'] ?? '';
    if (!empty($website) && !preg_match('/^(https?:\/\/)?([a-zA-Z0-9_-]+\.)+[a-zA-Z]{2,}(:\d{1,5})?(\/.*)?$/', $website)) {
        $errors['website'] = "Invalid website format.";
    }
    
    if (empty($errors)) {
        header("Location: index.php?action=registration_successful");
        exit();
    }
}
?>


  <div class="register">
    <h2>New User Registration</h2>
    <form action="" method="post">
        <label>Username: <input type="text" name="login" value="<?= htmlspecialchars($_POST['login'] ?? '') ?>"> </label><br>
        <span style="color:red;"> <?= $errors['login'] ?? '' ?> </span><br>
        
        <label>Password: 
    <div class="password-container">
        <input type="password" name="password" id="password">
        <button type="button" onclick="togglePassword('password', 'eye1')" id="eye1">🙈</button>
    </div>
    </label><br>

    <label>Confirm Password: 
      <div class="password-container">
        <input type="password" name="repeat_password" id="repeat_password">
        <button type="button" onclick="togglePassword('repeat_password', 'eye2')" id="eye2">🙈</button>
      </div>
    </label><br>

        <span style="color:red;"> <?= $errors['repeat_password'] ?? '' ?> </span><br>
        
        <label>Email: <input type="text" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"></label><br>
        <span style="color:red;"> <?= $errors['email'] ?? '' ?> </span><br>
        
        <label>My Website: <input type="text" name="website" value="<?= htmlspecialchars($_POST['website'] ?? '') ?>"></label><br>
        <span style="color:red;"> <?= $errors['website'] ?? '' ?> </span><br>
        
        <button type="submit">Register</button>
    </form>
    </div>

