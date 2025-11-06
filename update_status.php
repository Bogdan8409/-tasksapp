<?php
header('Content-Type: application/json');

// Conectare la baza de date
$conn = new mysqli("localhost", "root", "", "2webtasks");

// Verificare conexiune
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Conexiune eșuată']);
    exit;
}

// Primim datele JSON
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Validare date
if (!isset($data['id']) || !isset($data['status'])) {
    echo json_encode(['success' => false, 'error' => 'Date invalide']);
    exit;
}

$id = intval($data['id']);
$status = $data['status'];

// Validare status
if ($status !== 'open' && $status !== 'done') {
    echo json_encode(['success' => false, 'error' => 'Status invalid']);
    exit;
}

// Actualizare în baza de date
$stmt = $conn->prepare("UPDATE tasks SET status = ? WHERE id = ?");
if (!$stmt) {
    echo json_encode(['success' => false, 'error' => 'Eroare la pregătirea interogării: ' . $conn->error]);
    $conn->close();
    exit;
}
$stmt->bind_param("si", $status, $id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Status actualizat']);
    } else {
        echo json_encode(['success' => false, 'error' => 'ID inexistent sau status neschimbat']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Eroare la actualizare: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>