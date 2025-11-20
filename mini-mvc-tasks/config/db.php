<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "2webtasks";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>