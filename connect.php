<!-- this is the only page I cant complain about -->
<?php
require "header.php";
$host = "localhost";
$name = "NAMEHERE";
$db_username = "USERHERE";
$db_password = "PASSHERE";
$charset = "utf8mb4";

try {
    $dsn = "mysql:host=$host;dbname=$name;charset=$charset";
    $pdo = new PDO($dsn, $db_username, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
