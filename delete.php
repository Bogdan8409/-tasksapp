<?php include('db.php');?>

<?php
$id = (int) $_GET['id']; // asigură-te că e integer

$stmt = $pdo->prepare("DELETE FROM tasks WHERE id = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    echo "Task deleted.";
} else {
    echo "No task found.";
}
    
?>