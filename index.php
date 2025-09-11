<?php include('db.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda v.1</title>
</head>
<body>
    <form action="submit.php" method="post">
        <input type="text" name="title" pattern=".{1,20}"  required>
        <input type="date" name="dates" pattern="\d{4}-\d{2}-\d{2}">
        <label for="starttime">Ora de incepere</label>
        <input type="time" name="starttime">
        <label for="endtime">Ora sfarsit</label>
        <input type="time" name="endtime">
        <textarea name="notes"></textarea>
        <input type="submit" value="submit" name="submit">
    </form>
     <div>
        <a href="index.php">Acasa</a>
        <a href="tasks_schedule.php">Lista programari</a>
        <a href="submit.php">submit</a>
        <a href="edit.php">Actualizare date</a>
    </div> 
</body>
</html>