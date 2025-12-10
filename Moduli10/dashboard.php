<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Table</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            padding: 30px;
        }

        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        thead {
            background: #4a90e2;
            color: white;
        }

        tr:hover {
            background: #f1f1f1;
        }

        th:first-child, td:first-child {
            width: 60px;
            text-align: center;
        }
    </style>
</head>
<body>

<?php
include_once("config.php");
$sql = "SELECT * FROM users";
$getUsers = $conn->prepare($sql);
$getUsers->execute();
$users = $getUsers->fetchAll();
?>

<table>
    <thead>
        <th>ID</th>
        <th>Name</th>
        <th>Surname</th>
        <th>Email</th>
    </thead>

    <tbody>
        <?php foreach ($users as $user) { ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= $user['name'] ?></td>
                <td><?= $user['surname'] ?></td>
                <td><?= $user['email'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<a href="add.php">Add</a>
</body>
</html>
