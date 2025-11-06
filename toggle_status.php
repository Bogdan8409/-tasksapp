<?php
include 'db.php';

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])){
    $id = $_POST['id'];

    // Preluăm statusul curent
    $stmt = $conn->prepare("SELECT status FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($status);
    $stmt->fetch();
    $stmt->close();

    if(!$status){
        echo json_encode(['success'=>false,'message'=>'Task-ul nu există']);
        exit;
    }

    // Toggle status
    $new_status = ($status === 'finalizat') ? 'în curs' : 'finalizat';

    $stmt = $conn->prepare("UPDATE tasks SET status=? WHERE id=?");
    $stmt->bind_param("si", $new_status, $id);
    $stmt->execute();
    $stmt->close();

    echo json_encode(['success'=>true,'new_status'=>$new_status]);
}
?>
