<?php
include_once("config.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM users WHERE id = :id";
    $deleteQuery = $conn->prepare($sql);
    $deleteQuery->bindParam(":id", $id, PDO::PARAM_INT);
    $deleteQuery->execute();
}


header("Location: dashboard.php");
exit();
