<?php
include('db.php');

// Funcții securitate
function sanitizeInput($v) {
  return trim($v);
}

function escapeOutput($v) {
  return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8');
}

function validateDate($date, $format = 'Y-m-d') {
  $d = DateTime::createFromFormat($format, $date);
  return $d && $d->format($format) === $date;
}

function validateTime($time) {
  return preg_match('/^(2[0-3]|[01]?[0-9]):([0-5]?[0-9])$/', $time);
}

// === Preluare date ===
$title     = sanitizeInput($_POST['title']     ?? '');
$dates     = sanitizeInput($_POST['dates']     ?? '');
$starttime = sanitizeInput($_POST['starttime'] ?? '');
$endtime   = sanitizeInput($_POST['endtime']   ?? '');
$notes     = sanitizeInput($_POST['notes']     ?? '');
$status    = 'open'; // implicit

// === Validare server-side ===
$errors = [];

if ($title === '' || strlen($title) > 100) {
  $errors[] = "Titlul este obligatoriu (max 100 caractere).";
}
if (!validateDate($dates)) {
  $errors[] = "Data introdusă nu este validă.";
}
if (!validateTime($starttime) || !validateTime($endtime)) {
  $errors[] = "Formatul orei este invalid.";
}
if ($endtime <= $starttime) {
  $errors[] = "Ora de sfârșit trebuie să fie după ora de început.";
}
if (strlen($notes) > 500) {
  $errors[] = "Notițele nu pot depăși 500 de caractere.";
}

if (!empty($errors)) {
  // Returnăm erori ca JSON (pentru AJAX)
  header('Content-Type: application/json');
  echo json_encode(['success' => false, 'errors' => $errors]);
  exit;
}

// === Salvare în DB ===
try {
  $stmt = $pdo->prepare("INSERT INTO tasks (title, dates, starttime, endtime, notes, status) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->execute([$title, $dates, $starttime, $endtime, $notes, $status]);

  header('Content-Type: application/json');
  echo json_encode(['success' => true, 'message' => 'Programare adăugată cu succes.']);
} catch (PDOException $e) {
  header('Content-Type: application/json');
  echo json_encode(['success' => false, 'errors' => ['Eroare la salvare: '.$e->getMessage()]]);
}
