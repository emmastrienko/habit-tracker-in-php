<?php
session_start();
require_once './config/db.php';

$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    echo "<p>Будь ласка, увійдіть у систему, щоб бачити свої цілі.</p>";
    exit;
}

$sql = "SELECT * FROM goals WHERE user_id = :user_id ORDER BY completed, id DESC";
$stmt = $conn->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$goals = $stmt->fetchAll();
?>

<style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #333;
  }

  h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #2c3e50;
  }

  ul.goals-list {
    list-style: none;
    padding: 0;
    max-width: 700px;
    margin: 0 auto 30px;
  }

  ul.goals-list li {
    background: white;
    padding: 15px 20px;
    margin-bottom: 12px;
    border-radius: 8px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  ul.goals-list li[style*="line-through"] {
    opacity: 0.6;
  }

  ul.goals-list li b {
    flex: 1;
  }

  .goal-actions a {
    margin-left: 15px;
    text-decoration: none;
    color: #3498db;
    font-weight: 600;
    transition: color 0.3s ease;
  }

  .goal-actions a:hover {
    color: #2980b9;
  }

  .no-goals {
    text-align: center;
    color: #777;
    font-style: italic;
  }

  .add-goal-link {
    display: block;
    text-align: center;
    font-size: 1.1rem;
    color: white;
    background-color: #27ae60;
    padding: 12px 20px;
    border-radius: 6px;
    width: 250px;
    margin: 10px auto;
    text-decoration: none;
    font-weight: 700;
    transition: background-color 0.3s ease;
  }

  .add-goal-link:hover {
    background-color: #1e8449;
  }
</style>

<h2>Мої цілі</h2>

<?php if (count($goals) === 0): ?>
    <p class="no-goals">У вас поки немає цілей.</p>
<?php else: ?>
    <ul class="goals-list">
        <?php foreach ($goals as $row): ?>
            <li style="<?= $row['completed'] ? 'text-decoration: line-through;' : '' ?>">
                <b><?= htmlspecialchars($row['text']) ?></b>
                <span>[<?= $row['area_name'] ?>]</span>
                <span class="goal-actions">
                    <?php if (!$row['completed']): ?>
                       <a href="index.php?action=complete_goal&id=<?= (int)$row['id'] ?>">✅ Завершити</a>
                    <?php endif; ?>
                    <?php if (!empty($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
    <a href="index.php?action=edit_goal&id=<?= (int)$row['id'] ?>">✏️ Редагувати</a>
    <a href="index.php?action=delete_goal&id=<?= (int)$row['id'] ?>" onclick="return confirm('Ви впевнені, що хочете видалити ціль?')">🗑️ Видалити</a>
<?php endif; ?>

                </span>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<a href="index.php?action=create_goal" class="add-goal-link">➕ Додати нову ціль</a>
