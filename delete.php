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
if (!isset($data['id'])) {
    echo json_encode(['success' => false, 'error' => 'Date invalide']);
    exit;
}

$id = intval($data['id']);

// Ștergere din baza de date
$stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Task șters']);
} else {
    echo json_encode(['success' => false, 'error' => 'Eroare la ștergere']);
}

$stmt->close();
$conn->close();
?>