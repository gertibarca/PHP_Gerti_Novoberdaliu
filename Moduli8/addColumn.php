<?php
$host = "localhost";
$db   = "test";
$user = "root";
$pass = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
    $check = $conn->prepare("
        SELECT COUNT(*) 
        FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE table_schema = :db 
        AND table_name = 'users' 
        AND column_name = 'email'
    ");

    $check->execute(['db' => $db]);
    $exists = $check->fetchColumn();

    if ($exists == 0) {
        
        $sql = "ALTER TABLE users ADD COLUMN email VARCHAR(255) NULL";
        $conn->exec($sql);
        echo "Column 'email' added successfully!";
    } else {
        echo "Column 'email' already exists — no changes made.";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
