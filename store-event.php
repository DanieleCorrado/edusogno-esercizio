<?php

$mysqli = require __DIR__ . "./assets/db/database.php";

$attendees = $_POST['attendees'];
$name = $_POST['name'];
$date = $_POST['date'] . " " . $_POST['time'];

// Prepara la query di inserimento

$sql = "INSERT INTO eventi (attendees, nome_evento, data_evento) VALUES ('$attendees', '$name', '$date')";

$stmt = $mysqli->stmt_init();

$stmt = $mysqli->prepare($sql);

if($stmt->execute()) {

 header("Location:user-events.php");
 echo "event added successfully";
 exit;

} 

