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
            <li onclick="toggleComplete(this)">Be Proactive</li>
            <li onclick="toggleComplete(this)">Begin with the End in Mind</li>
            <li onclick="toggleComplete(this)">Put First Things First</li>
            <li onclick="toggleComplete(this)">Think Win-Win</li>
            <li onclick="toggleComplete(this)">Seek First to Understand, Then to Be Understood</li>
            <li onclick="toggleComplete(this)">Synergize</li>
            <li onclick="toggleComplete(this)">Sharpen the Saw</li>
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