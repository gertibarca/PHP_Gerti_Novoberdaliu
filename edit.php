<?php
include_once("config.php");

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$id = $_GET['id'];

$sql = "SELECT * FROM users WHERE id = :id";
$getUser = $conn->prepare($sql);
$getUser->bindParam(":id", $id, PDO::PARAM_INT);
$getUser->execute();
$user = $getUser->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
</head>
<body>

<h2>Edit User</h2>

<form action="update.php" method="POST">
    <input type="hidden" name="id" value="<?= $user['id'] ?>">

    <input type="text" name="name" value="<?= $user['name'] ?>" required>
    <input type="text" name="surname" value="<?= $user['surname'] ?>" required>
    <input type="email" name="email" value="<?= $user['email'] ?>" required>

    <button type="submit" name="update">Update</button>
</form>

<a href="dashboard.php">Back to Dashboard</a>

</body>
</html>
