<?php
include_once("config.php");

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];

    $sql = "UPDATE users 
            SET name = :name, surname = :surname, email = :email 
            WHERE id = :id";

    $updateQuery = $conn->prepare($sql);
    $updateQuery->bindParam(":name", $name);
    $updateQuery->bindParam(":surname", $surname);
    $updateQuery->bindParam(":email", $email);
    $updateQuery->bindParam(":id", $id, PDO::PARAM_INT);

    $updateQuery->execute();
}

header("Location: dashboard.php");
exit();
