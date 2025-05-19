<?php
session_start();
require_once './config/db.php';

$goal_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$user_id = $_SESSION['user_id'] ?? null;

if (!$goal_id || !$user_id) {
    die("Invalid request.");
}

// Отримати ціль користувача
$stmt = $conn->prepare("SELECT * FROM goals WHERE id = :id AND user_id = :user_id");
$stmt->execute(['id' => $goal_id, 'user_id' => $user_id]);
$goal = $stmt->fetch();

if (!$goal) {
    die("Goal not found or not authorized.");
}

// Якщо форма надіслана
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $text = trim($_POST['text']);
    $difficulty = $_POST['difficulty'];
    $area_name = trim($_POST['area_name']);

    if ($text && $difficulty && $area_name) {
        $update = $conn->prepare("UPDATE goals SET text = :text, difficulty = :difficulty, area_name = :area_name WHERE id = :id AND user_id = :user_id");
        $update->execute([
            'text' => $text,
            'difficulty' => $difficulty,
            'area_name' => $area_name,
            'id' => $goal_id,
            'user_id' => $user_id
        ]);

        header("Location: index.php?action=goals");
        exit;
    } else {
        $error = "Будь ласка, заповніть усі поля.";
    }
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
  <h2>Редагувати ціль</h2>
  <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>

  <form method="post">
    <label for="text">Текст:</label>
    <textarea id="text" name="text" required><?= htmlspecialchars($goal['text']) ?></textarea>

    <label for="difficulty">Складність:</label>
    <select id="difficulty" name="difficulty" required>
      <option value="">-- Виберіть складність --</option>
      <option value="easy" <?= $goal['difficulty'] === 'easy' ? 'selected' : '' ?>>easy</option>
      <option value="medium" <?= $goal['difficulty'] === 'medium' ? 'selected' : '' ?>>medium</option>
      <option value="hard" <?= $goal['difficulty'] === 'hard' ? 'selected' : '' ?>>hard</option>
    </select>

    <label for="area_name">Область:</label>
    <select id="area_name" name="area_name" required>
      <?php
      $areas = [
        "Health & Fitness",
        "Personal Growth & Learning",
        "Career & Finances",
        "Relationships & Social Life",
        "Emotional & Mental Well-being",
        "Hobbies & Creativity",
        "Purpose & Spirituality"
      ];
      foreach ($areas as $area) {
          $selected = $goal['area_name'] === $area ? 'selected' : '';
          echo "<option value=\"$area\" $selected>$area</option>";
      }
      ?>
    </select>

    <button type="submit">Зберегти зміни</button>
  </form>
</div>
