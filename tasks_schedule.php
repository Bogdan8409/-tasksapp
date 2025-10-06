<div>
  <a href="index.php">Acasa</a>
  <a href="tasks_schedule.php">Lista programari</a>
  <a href="edit.php">Actualizare date</a>
</div>   
<?php
require_once('db.php');
$sql = "SELECT * FROM tasks";
$result = $pdo->query($sql);
$id = $_GET['id'];

foreach($result as $row) {
    echo '<br>';
    echo "id: " . $row['id']. " - Data de inceput: " . $row['starttime']. " " . $row['title']. " " . $row['dates']. " " . $row['endtime']. " " . $row['notes']. "<br>";
    echo '<a href="edit.php?id=' . urlencode($row['id']) . '">Editeaza</a>';
    echo '<a href="delete.php?id=' . urlencode($row['id']) . '">Sterge</a>';
    ?>
    
    <?php
}

?>