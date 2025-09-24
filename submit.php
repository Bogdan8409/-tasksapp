<?php
include('db.php');
?>
<div>
  <a href="index.php">Acasa</a>
  <a href="tasks_schedule.php">Lista programari</a>
  <a href="edit.php">Actualizare date</a>
</div> 
    <form action="db.php" method="post">
    <!-- ID-ul -->
    <input type="hidden" name="id" value="<?php echo $id; ?>">

    <!-- Titlu -->
    <input type="text" name="title" value="<?= isset($title) ? htmlspecialchars($title) : '' ?>" required>

    <!-- Data -->
    <input type="date" name="dates" value="<?php echo $dates; ?>">

    <!-- Ora de început -->
    <label for="starttime">Ora de începere</label>
    <input type="time" name="starttime" value="<?php echo $starttime; ?>">

    <!-- Ora de sfârșit -->
    <label for="endtime">Ora sfârșit</label>
    <input type="time" name="endtime" value="<?php echo $endtime; ?>">

    <!-- Notițe -->
    <label for="notes">Notițe</label>
    <textarea name="notes"><?= isset($notes) ? htmlspecialchars($notes) : ''; ?></textarea>

    <!-- Buton submit -->
    <button type="submit" name="update">Update</button>
</form>

    <?php   
    $title = $_POST['title'] ?? '';
    $dates = $_POST['dates'] ?? '';
    $starttime = $_POST['starttime'] ?? '';
    $endtime = $_POST['endtime'] ?? '';
    $notes = $_POST['notes'] ?? '';

    $dt = DateTime::createFromFormat('Y-m-d', $dates);


    // Display the submitted data
    echo "Ora de inceput: " . $starttime . "<br>";
    echo "Ora de sfarsit: " . $endtime . "<br>";
    echo "Titlu: " . $title . "<br>";
    echo "Data: " . $dates . "<br>";
    echo "Notite: " . $notes;

 
?>