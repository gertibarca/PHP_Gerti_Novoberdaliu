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

        .actions a {
            margin-right: 10px;
            text-decoration: none;
            color: #4a90e2;
        }

        .actions a:hover {
            text-decoration: underline;
        }

        .add-btn {
            display: block;
            width: 120px;
            margin: 20px auto;
            padding: 10px;
            text-align: center;
            background: #4a90e2;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        .add-btn:hover {
            background: #357abd;
        }
    </style>
</head>
<body>

<?php
include_once("config.php");

$sql = "SELECT * FROM users";
$getUsers = $conn->prepare($sql);
$getUsers->execute();
$users = $getUsers->fetchAll(PDO::FETCH_ASSOC);
?>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Surname</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php if (count($users) > 0): ?>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id']) ?></td>
                    <td><?= htmlspecialchars($user['name']) ?></td>
                    <td><?= htmlspecialchars($user['surname']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td class="actions">
                        <a href="edit.php?id=<?= $user['id'] ?>">Update</a>
                        <a href="delete.php?id=<?= $user['id'] ?>"
                           onclick="return confirm('Are you sure you want to delete this user?');">
                           Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" style="text-align:center;">No users found</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<a href="add.php" class="add-btn">Add User</a>

</body>
</html>
