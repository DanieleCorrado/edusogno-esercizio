<?php

// VALIDAZIONE DATI FORM

// Validazione nome

if( empty($_POST["name"])) {
 die("Name is required");
}

// Validazione cognome

if( empty($_POST["surname"])) {
 die("Surname is required");
}

// Validazione email

if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
 die("Valid email is required");
}

// Validazione password

if (strlen($_POST["password"]) < 8) {
 die("Password must be at least 8 characters");
}

if (!preg_match("/[a-z]/i", $_POST["password"])) {
 die("Password must contain at least one letter");
}

// Hashing password

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

// Richiamo il DB

$mysqli = require __DIR__ . "./assets/db/database.php";

mysqli_report(MYSQLI_REPORT_OFF);

// Aggiungo l'istanza alla tabella utenti

$sql = "INSERT INTO utenti (nome, cognome, email, password) VALUES (?, ?, ?, ?)";

$stmt = $mysqli->stmt_init();

if(!$stmt->prepare($sql)) {
 die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("ssss", $_POST["name"], $_POST["surname"], $_POST["email"], $password_hash);

if($stmt->execute()) {

 header("Location:user-event.html");
 exit;

} else {

 if($mysqli->errno === 1062) {

  die("Email already taken");

 } else {

  die($mysqli->error . " " . $mysqli->errno);

 }
}