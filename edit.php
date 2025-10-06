<?php
include('db.php');

// --- Funcții utile pentru securitate ---
function sanitizeInput($value) {
    return trim($value);
}

function escapeOutput($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function validateDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

function validateTime($time) {
    return preg_match('/^(2[0-3]|[01]?[0-9]):([0-5]?[0-9])$/', $time);
}

// --- Variabile ---
$error = '';
$success = '';
$id = 0;
$title = $dates = $starttime = $endtime = $notes = '';

// --- 1️⃣ Preluare date pentru editare ---
if (isset($_GET['id']) && (int)$_GET['id'] > 0) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $title     = $row['title'];
        $dates     = $row['dates'];
        $starttime = $row['starttime'];
        $endtime   = $row['endtime'];
        $notes     = $row['notes'];
    } else {
        $error = "Programarea nu a fost găsită.";
    }
}

// --- 2️⃣ Procesare formular ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    $id        = (int)($_POST['id'] ?? 0);
    $title     = sanitizeInput($_POST['title'] ?? '');
    $dates     = sanitizeInput($_POST['dates'] ?? '');
    $starttime = sanitizeInput($_POST['starttime'] ?? '');
    $endtime   = sanitizeInput($_POST['endtime'] ?? '');
    $notes     = sanitizeInput($_POST['notes'] ?? '');

    // --- 🔍 Validări server-side ---
    if ($id <= 0) {
        $error = "ID invalid.";
    } elseif ($title === '' || strlen($title) > 100) {
        $error = "Titlul este obligatoriu și trebuie să aibă cel mult 100 de caractere.";
    } elseif (!validateDate($dates)) {
        $error = "Data introdusă nu este validă.";
    } elseif (!validateTime($starttime) || !validateTime($endtime)) {
        $error = "Formatul orelor este invalid.";
    } elseif ($endtime <= $starttime) {
        $error = "Ora de sfârșit trebuie să fie după ora de început.";
    } elseif (strlen($notes) > 500) {
        $error = "Notițele nu pot depăși 500 de caractere.";
    } else {
        // --- ✅ Actualizare în baza de date ---
        $stmt = $pdo->prepare("
            UPDATE tasks 
            SET title = ?, dates = ?, starttime = ?, endtime = ?, notes = ? 
            WHERE id = ?
        ");
        if ($stmt->execute([$title, $dates, $starttime, $endtime, $notes, $id])) {
            $success = "Programarea a fost actualizată cu succes.";
        } else {
            $error = "Eroare la actualizare.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
<meta charset="UTF-8">
<title>Editare programare</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
  <div class="nav">
    <a href="index.php">Acasă</a>
    <a href="tasks_schedule.php">Lista programări</a>
    <a href="edit.php">Actualizare date</a>
  </div>

  <?php if ($error): ?>
    <div class="alert error"><?php echo escapeOutput($error); ?></div>
  <?php elseif ($success): ?>
    <div class="alert success"><?php echo escapeOutput($success); ?></div>
  <?php endif; ?>

  <form action="edit.php" method="post" novalidate>
    <input type="hidden" name="id" value="<?php echo (int)$id; ?>">

    <label for="title">Titlu *</label>
    <input type="text" id="title" name="title" maxlength="100"
           value="<?php echo escapeOutput($title); ?>" required>

    <label for="dates">Data *</label>
    <input type="date" id="dates" name="dates"
           value="<?php echo escapeOutput($dates); ?>" required>

    <label for="starttime">Ora de începere *</label>
    <input type="time" id="starttime" name="starttime"
           value="<?php echo escapeOutput($starttime); ?>" required>

    <label for="endtime">Ora sfârșit *</label>
    <input type="time" id="endtime" name="endtime"
           value="<?php echo escapeOutput($endtime); ?>" required>

    <label for="notes">Notițe</label>
    <textarea id="notes" name="notes" rows="4" maxlength="500"><?php echo escapeOutput($notes); ?></textarea>

    <button type="submit" name="save" class="btn-primary">Salvează</button>
  </form>

  <hr>

  <h3>Lista programărilor</h3>
  <table class="tasks-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Titlu</th>
        <th>Data</th>
        <th>Start</th>
        <th>End</th>
        <th>Note</th>
        <th>Acțiuni</th>
      </tr>
    </thead>
    <tbody>
    <?php
    $stmt = $pdo->query("SELECT * FROM tasks ORDER BY dates DESC, starttime DESC");
    foreach ($stmt as $row):
    ?>
      <tr>
        <td><?php echo escapeOutput($row['id']); ?></td>
        <td><?php echo escapeOutput($row['title']); ?></td>
        <td><?php echo escapeOutput($row['dates']); ?></td>
        <td><?php echo escapeOutput($row['starttime']); ?></td>
        <td><?php echo escapeOutput($row['endtime']); ?></td>
        <td><?php echo escapeOutput($row['notes']); ?></td>
        <td>
          <a href="edit.php?id=<?php echo escapeOutput($row['id']); ?>">Editează</a> |
          <a href="delete.php?id=<?php echo escapeOutput($row['id']); ?>" onclick="return confirm('Sigur vrei să ștergi această programare?')">Șterge</a>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
</body>
</html>
