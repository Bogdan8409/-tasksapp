<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "2webtasks";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificăm dacă formularul a fost trimis
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Preluăm valorile din formular
        $id     = $_POST['id'] ?? '';
        $title     = $_POST['title'] ?? '';
        $dates     = $_POST['dates'] ?? '';
        $starttime = $_POST['starttime'] ?? '';
        $endtime   = $_POST['endtime'] ?? '';
        $notes     = $_POST['notes'] ?? '';
      
        // Pregătim interogarea SQL
        $sql = "INSERT INTO tasks (title, dates, starttime, endtime, notes)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);

        // Executăm cu valorile primite
        $stmt->execute([$title, $dates, $starttime, $endtime, $notes]);

        echo "Task adăugat cu succes!";
    }
} catch (PDOException $e) {
    echo "Eroare: " . $e->getMessage();
}
?>