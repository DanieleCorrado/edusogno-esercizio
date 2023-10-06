<?php
session_start();
print_r($_POST);

$mysqli = require __DIR__ . "./assets/db/database.php";

mysqli_report(MYSQLI_REPORT_OFF);

// Modifico l'evento

$date = $_POST['date']. " " . $_POST['time'];
// print_r("---------------");


$sql = "UPDATE eventi SET nome_evento = ?, attendees = ?, data_evento = ? WHERE id = ?";

$stmt = $mysqli->stmt_init();

if(!$stmt->prepare($sql)) {
 die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("ssss", $_POST["name"], $_POST["attendees"], $date, $_POST["id"]);

if($stmt->execute()) {

 header("Location:dashboard.php");
 exit;

} else {

 if($mysqli->errno === 1062) {

  die("Email already taken");

 } else {

  die($mysqli->error . " " . $mysqli->errno);

 }
}