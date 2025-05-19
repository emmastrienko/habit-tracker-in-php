<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once './config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $text = trim($_POST['text']);
    $difficulty = (int)$_POST['difficulty'];
    $area_name = trim($_POST['area_name']);  // якщо ти змінив на area_name
    $user_id = $_SESSION['user_id'] ?? null;

    var_dump($_POST);
    var_dump($user_id);

    if ($text && $user_id && $area_name) {
        $stmt = $conn->prepare("INSERT INTO goals (user_id, area_name, text, difficulty) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $area_name, $text, $difficulty]);

        if ($stmt->rowCount() > 0) {
            echo "<p>Дані успішно додані до бази!</p>";
            header("Location: index.php?action=goals"); 
            exit;
        } else {
            echo "<p>Дані НЕ додані до бази!</p>";
            print_r($stmt->errorInfo());
        }
    } else {
        echo "<p class='error'>Заповніть всі поля та авторизуйтесь!</p>";
    }
    exit; // щоб не було редіректу під час тесту
}


?>

<style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #333;
  }

  .container {
    padding-top: 120px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin-bottom: 40px;
  }

  h2 {
    color: rgb(255, 255, 255);
    margin-bottom: 1rem;
  }

  form {
    background: white;
    padding: 1.5rem 2rem;
    max-width: 400px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgb(0 0 0 / 0.1);
  }

  label {
    font-weight: 600;
    display: block;
    margin-top: 1rem;
    margin-bottom: 0.3rem;
  }

  textarea, input[type="number"], select {
    width: 100%;
    padding: 0.5rem;
    font-size: 1rem;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-family: inherit;
  }

  button {
    margin-top: 1.5rem;
    background-color: #3498db;
    color: white;
    border: none;
    padding: 0.7rem 1.2rem;
    font-size: 1rem;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  button:hover {
    background-color: #2980b9;
  }

  .error {
    color: #e74c3c;
    margin-top: 1rem;
    font-weight: 600;
  }
</style>

<div class="container">
<h2>Нова ціль</h2>
<form method="post" novalidate>
    <label for="text">Текст:</label>
    <textarea id="text" name="text" required></textarea>

    <label for="difficulty">Складність:</label>
    <select id="difficulty" name="difficulty" required>
    <option value="">-- Виберіть складність --</option>
    <option value="easy">easy</option>
    <option value="medium">medium</option>
    <option value="hard">hard</option>
</select>

    <label for="area_name">Область:</label>
<select id="area_name" name="area_name" required>
    <option value="">-- Виберіть область --</option>
    <option value="Health & Fitness">Health & Fitness</option>
    <option value="Personal Growth & Learning">Personal Growth & Learning</option>
    <option value="Career & Finances">Career & Finances</option>
    <option value="Relationships & Social Life">Relationships & Social Life</option>
    <option value="Emotional & Mental Well-being">Emotional & Mental Well-being</option>
    <option value="Hobbies & Creativity">Hobbies & Creativity</option>
    <option value="Purpose & Spirituality">Purpose & Spirituality</option>
</select>


    <button type="submit">Створити</button>
</form>
</div>
