<?php
// Avvia una sessione

session_start();

// Carico il file di connessione al database

$mysqli = require __DIR__ . "./assets/db/database.php";

// Disabilito la segnalazione degli errori del database

mysqli_report(MYSQLI_REPORT_OFF);

// Recupero i dati dell'evento dal post

$date = $_POST['date']. " " . $_POST['time'];

// Preparo la query di modifica dell'evento nel database

$sql = "UPDATE eventi SET nome_evento = ?, attendees = ?, data_evento = ? WHERE id = ?";

// Creo una prepared statement

$stmt = $mysqli->stmt_init();

// Verifico se la prepared statement può essere preparata

if(!$stmt->prepare($sql)) {
 die("SQL error: " . $mysqli->error);
}

// Lego i parametri della prepared statement

$stmt->bind_param("ssss", $_POST["name"], $_POST["attendees"], $date, $_POST["id"]);

// Eseguo la prepared statement

if($stmt->execute()) {

 // Reindirizzo l'utente alla pagina dashboard.php

 header("Location:dashboard.php");
 exit;

}