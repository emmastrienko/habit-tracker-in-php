<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fitness Tracker</title>
  <link rel="stylesheet" href="./styles.css"/>
</head>
<body>
  <header>
    <h1>Fitness Traker </h1>
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
