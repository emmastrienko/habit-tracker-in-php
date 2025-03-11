<?php
include './layout/header.php';
include './layout/right_menu.php';

// Визначаємо шлях до сторінки
$action = $_GET['action'] ?? 'main';
$page = "views/$action.php";

// Перевіряємо, чи існує файл, якщо ні — завантажуємо main.php
if (!file_exists($page) || !is_file($page)) {
    $page = 'views/main.php';
}

include $page;

include './layout/footer.php';
?>