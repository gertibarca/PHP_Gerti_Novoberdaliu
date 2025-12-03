<?php
$host = 'localhost';
$db   = 'test';
$user = 'root';
$pass = '';

try {
    // Create PDO connection
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL to create table
    $sql = "CREATE TABLE IF NOT EXISTS users (
                id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(30) NOT NULL,
                password VARCHAR(50) NOT NULL
            )";

    // Use $conn instead of $pdo
    $conn->exec($sql);

    echo "Table created successfully";

} catch (Exception $e) {
    echo "Error creating table: " . $e->getMessage();
}
?>
