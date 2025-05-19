<?php
require_once './config/db.php';

$defaultGoals = [
    "Be Proactive",
    "Begin with the End in Mind",
    "Put First Things First",
    "Think Win-Win",
    "Seek First to Understand, Then to Be Understood",
    "Synergize",
    "Sharpen the Saw"
];

$userGoals = $defaultGoals;

if (!empty($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    // Припустимо, у таблиці goals зберігаються цілі користувача у вигляді тексту (goal_text)
    // і є поле user_id
    $stmt = $conn->prepare("SELECT text FROM goals WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $userGoals = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Якщо цілей немає, залишаємо дефолтні
    if (!$userGoals) {
        $userGoals = $defaultGoals;
    }
}
?>
<main>
  <div class="conteiner">
    <div class="image-conteiner">
      <img src="./images/makima.png" />
    </div>
    <div class="chart-conteiner">
      <canvas id="lifeRadarChart"></canvas>
    </div>
    
    <div class="todo-container">
        <ul id="todo-list">
            <?php foreach ($userGoals as $goal): ?>
                <li onclick="toggleComplete(this)"><?= htmlspecialchars($goal) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
  </div>


<script>
    const ctx = document.getElementById('lifeRadarChart').getContext('2d');

    new Chart(ctx, {
        type: 'radar',
        data: {
            labels: [
                "Health & Fitness", 
                "Personal Growth & Learning", 
                "Career & Finances", 
                "Relationships & Social Life", 
                "Emotional & Mental Well-being", 
                "Hobbies & Creativity", 
                "Purpose & Spirituality"
            ],
            datasets: [{
                label: "Life Balance",
                data: [8, 6, 7, 9, 5, 7, 6], 
                fill: true,
                backgroundColor: "rgba(175, 4, 4, 0.2)",
                borderColor: "rgb(175, 4, 4)",
                pointBackgroundColor: "rgb(175, 4, 4)",
                pointBorderColor: "#fff",
                pointHoverBackgroundColor: "#fff",
                pointHoverBorderColor: "rgb(175, 4, 4)"
            }]
        },
        options: {
            responsive: true,
            scales: {
                r: {
                    min: 0,
                    max: 10,
                    ticks: {
                        stepSize: 1,
                        backdropColor: 'transparent'
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top'
                }
            }
        }
    });

    function toggleComplete(item) {
            item.classList.toggle("completed");
        }
</script>
  </main>