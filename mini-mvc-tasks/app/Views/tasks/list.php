<?php
include_once '../../config/db.php';
include_once '../Models/Task.php';

$taskModel = new Task();
$tasks = $taskModel->getAllTasks();

?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Lista Sarcini</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .container { margin-top: 50px; }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center">Lista Sarcini</h2>
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titlu</th>
                <th>Data</th>
                <th>Începe la</th>
                <th>Se termină la</th>
                <th>Status</th>
                <th>Acțiuni</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($tasks): ?>
                <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td><?= htmlspecialchars($task['id']) ?></td>
                        <td><?= htmlspecialchars($task['title']) ?></td>
                        <td><?= htmlspecialchars($task['dates']) ?></td>
                        <td><?= htmlspecialchars($task['starttime']) ?></td>
                        <td><?= htmlspecialchars($task['endtime']) ?></td>
                        <td><?= htmlspecialchars($task['status']) ?></td>
                        <td>
                            <a href="edit.php?id=<?= htmlspecialchars($task['id']) ?>" class="btn btn-warning">Editează</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">Nu există sarcini disponibile.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <a href="edit.php" class="btn btn-primary">Adaugă Sarcină</a>
</div>

</body>
</html>