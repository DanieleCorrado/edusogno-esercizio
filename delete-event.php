<?php

// Verifica dell'esistenza dell'id dell'evento

if (!isset($_POST['id'])) {
    header("Location: dashboard.php");
    exit;
}

// Connessione al database
$mysqli = require __DIR__ . "./assets/db/database.php";

$id = $_POST['id'];
// Query di cancellazione dell'evento
 $sql = "DELETE FROM eventi WHERE id = $id";

 $stmt = $mysqli->stmt_init();

// // Preparazione della query
 if(!$stmt->prepare($sql)) {
  die("SQL error: " . $mysqli->error);
 }

// Esecuzione della query
 $result = $stmt->execute();

// Redirect alla dashboard
 header("Location: dashboard.php");
 exit;

?>
