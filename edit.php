<?php
include('db.php');
$id = isset($_POST['id']);
?>
 <div>
  <a href="index.php">Acasa</a>
  <a href="tasks_schedule.php">Lista programari</a>
  <a href="edit.php">Actualizare date</a>
</div> 

    <form action="edit.php" method="post">

    <input type="hidden" name="id" value="<?php echo $id; ?>">


    <input type="text" name="title" value="<?= isset($title) ? htmlspecialchars($title) : '' ?>" required>


    <input type="date" name="dates" value="<?php echo $dates; ?>">

  
    <label for="starttime">Ora de începere</label>
    <input type="time" name="starttime" value="<?php echo $starttime; ?>">


    <label for="endtime">Ora sfârșit</label>
    <input type="time" name="endtime" value="<?php echo $endtime; ?>">


    <label for="notes">Notițe</label>
    <textarea name="notes"><?= isset($notes) ? htmlspecialchars($notes) : ''; ?></textarea>

    <button type="submit" name="save">Salveaza</button>
</form>
<?php


$id = isset($_POST['id']) ? (int)$_POST['id']: '$id';
$title     = $_POST['title']     ?? '';
$dates     = $_POST['dates']     ?? '';
$starttime = $_POST['starttime'] ?? '';
$endtime   = $_POST['endtime']   ?? '';
$notes     = $_POST['notes']     ?? '';
var_dump($_POST);

if (isset($_POST['save'])) {
    if (!empty($id)) {
       
        $sql = "UPDATE tasks 
        SET title=?, dates=?, starttime=?, endtime=?, notes=? 
        WHERE id=?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $title,
            $dates,
            $starttime,
            $endtime,
            $notes,
            $id
        ]);

        echo "Task actualizat!";
    }
}
$sql = "SELECT * FROM tasks";
$result = $pdo->query($sql);

foreach($result as $row) {
    echo '<br>';
    echo "id: " . $row['id']. " - Data de inceput: " . $row['starttime']. " " . $row['title']. " " . $row['dates']. " " . $row['endtime']. " " . $row['notes']. "<br>";
    echo '<a href="edit.php?id=' . urlencode($row['id']) . '">Editeaza</a>';
    echo '<a href="delete.php?id=' . urlencode($row['id']) . '">Sterge</a>';
}
?>
