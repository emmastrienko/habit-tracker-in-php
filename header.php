<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Habit Tracker</title>
  <link rel="stylesheet" href="./styles.css?v=<?php echo time(); ?>">

  <link rel="icon" type="image/jpg" href="./images/icon.jpg">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400..800;1,400..800&family=Moon+Dance&display=swap" rel="stylesheet">

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <header>
    <h1>Habit Tracker </h1>
    <button id="menu-toggle">☰</button> 
  </header>

<script>
  document.addEventListener("DOMContentLoaded", function() {
        const menuToggle = document.getElementById("menu-toggle");
        const menu = document.getElementById("menu");

        menuToggle.addEventListener("click", function() {
            menu.classList.toggle("show"); 
        });

        document.addEventListener("click", function(event) {
            if (!menu.contains(event.target) && event.target !== menuToggle) {
                menu.classList.remove("show");
            }
        });
    });
</script>
