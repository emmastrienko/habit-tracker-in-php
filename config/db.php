<?php
$host = 'localhost'; // or your server address
$db   = 'habit_tracker'; // the database we created earlier
$user = 'root'; // your database username
$pass = '';     // your database password
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // throw errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,        // fetch assoc arrays
    PDO::ATTR_EMULATE_PREPARES   => false,                   // native prepared statements
];

try {
    $conn = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
