<?php
include 'db.php';
// ====================== CONFIGURARE CONEXIUNE ======================
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "2webtasks";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Eroare conexiune DB: " . $conn->connect_error);
}

// ====================== PRELUARE DATE EXISTENTE ======================
$id   = isset($_GET['id']) ? intval($_GET['id']) : 0;
$task = null;

if ($id > 0) {
  $sql  = "SELECT * FROM tasks WHERE id = $id";
  $result = $conn->query($sql);
  if ($result && $result->num_rows > 0) {
    $task = $result->fetch_assoc();
  }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  header('Content-Type: application/json; charset=utf-8');

  $id     = isset($_POST['id']) ? intval($_POST['id']) : 0;
  $title  = isset($_POST['title']) ? $_POST['title'] : '';
  $date   = isset($_POST['date']) ? $_POST['date'] : '';
  $start  = isset($_POST['start']) ? $_POST['start'] : '';
  $end    = isset($_POST['end']) ? $_POST['end'] : '';
  $notes  = isset($_POST['notes']) ? $_POST['notes'] : '';
  $status = isset($_POST['status']) ? $_POST['status'] : '';

  if ($id <= 0) {
    echo json_encode(["success" => false, "error" => "Invalid ID"]);
    exit;
  }

  $stmt = $conn->prepare("UPDATE tasks SET title=?, `dates`=?, `starttime`=?, `endtime`=?, notes=?, `status`=? WHERE id=?");
  if ($stmt) {
    $stmt->bind_param('ssssssi', $title, $date, $start, $end, $notes, $status, $id);
    if ($stmt->execute()) {
      echo json_encode(["success" => true]);
    } else {
      echo json_encode(["success" => false, "error" => $stmt->error]);
    }
    $stmt->close();
  } else {
    echo json_encode(["success" => false, "error" => $conn->error]);
  }
  exit;
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Editare sarcină</title>
  <!-- Bootstrap 4 -->
  <link rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body { background-color: #f8f9fa; }
    .card { max-width: 600px; margin: 50px auto; }
  </style>
</head>
<body>

<div class="container">
  <div class="card shadow-sm">
    <div class="card-body">
      <h4 class="card-title mb-4 text-center">✏️ Editare sarcină</h4>

      <?php if ($task): ?>
        <form id="editForm">
          <input type="hidden" name="id" value="<?= htmlspecialchars($task['id']) ?>">

          <div class="form-group">
            <label for="title">Titlu</label>
            <input type="text" class="form-control" id="title" name="title"
                   value="<?= htmlspecialchars($task['title']) ?>" required>
          </div>

          <div class="form-group">
            <label for="date">Data</label>
            <input type="date" class="form-control" id="date" name="date"
                   value="<?= htmlspecialchars($task['dates'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="start">Începe la</label>
              <input type="time" class="form-control" id="start" name="start"
                     value="<?= htmlspecialchars($task['starttime'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="form-group col-md-6">
              <label for="end">Se termină la</label>
              <input type="time" class="form-control" id="end" name="end"
                     value="<?= htmlspecialchars($task['endtime'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
          </div>

          <div class="form-group">
            <label for="notes">Note</label>
            <textarea class="form-control" id="notes" name="notes"
                      rows="3"><?= htmlspecialchars($task['notes']) ?></textarea>
          </div>

          <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status">
              <option value="open" <?= $task['status'] === 'open' ? 'selected' : '' ?>>Deschis</option>
              <option value="done" <?= $task['status'] === 'done' ? 'selected' : '' ?>>Finalizat</option>
            </select>
          </div>

          <button type="submit" class="btn btn-primary btn-block">💾 Salvează modificările</button>
          <a href="index.php" class="btn btn-secondary btn-block">⬅️ Înapoi</a>
        </form>
      <?php else: ?>
        <div class="alert alert-danger">Sarcina nu a fost găsită.</div>
      <?php endif; ?>

      <div id="msg" class="mt-3"></div>
    </div>
  </div>
</div>

<script>
  const form = document.getElementById('editForm');
  const msg  = document.getElementById('msg');

  form?.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(form);

    const response = await fetch('edit.php', {
      method: 'POST',
      body: formData
    });
    const result = await response.json();

    if (result.success) {
      msg.innerHTML = '<div class="alert alert-success">✅ Sarcina a fost actualizată cu succes!</div>';
      setTimeout(() => window.location.href = 'index.php', 1000);
    } else {
      msg.innerHTML = `<div class="alert alert-danger">❌ Eroare la actualizare: ${result.error || ''}</div>`;
    }
  });
</script>

</body>
</html>
