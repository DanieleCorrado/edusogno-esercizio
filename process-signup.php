<?php

// Avvia una sessione

session_start();

// Verifico se il nome è stato fornito

if( empty($_POST["name"])) {
 die("Name is required");
}

// Verifico se il nome è stato fornito

if( empty($_POST["surname"])) {
 die("Surname is required");
}

// Verifico se l'email è stata fornita


if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
 die("Valid email is required");
}

// Verifico la password

if (strlen($_POST["password"]) < 8) {
 die("Password must be at least 8 characters");
}

if (!preg_match("/[a-z]/i", $_POST["password"])) {
 die("Password must contain at least one letter");
}

// Creo un hash della password

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

// Carico il file di connessione al database

$mysqli = require __DIR__ . "./assets/db/database.php";

// Disabilito la segnalazione degli errori del database

mysqli_report(MYSQLI_REPORT_OFF);

// Preparo la query SQL per inserire l'istanza nella tabella utenti

$sql = "INSERT INTO utenti (nome, cognome, email, password, is_admin) VALUES (?, ?, ?, ?, ?)";

// Creo una prepared statement

$stmt = $mysqli->stmt_init();

// Verifico se la prepared statement può essere preparata

if(!$stmt->prepare($sql)) {
 die("SQL error: " . $mysqli->error);
}

// Lego i parametri della prepared statement

$is_admin = 0;
$stmt->bind_param("sssss", $_POST["name"], $_POST["surname"], $_POST["email"], $password_hash, $is_admin);

// Eseguo la prepared statement

if($stmt->execute()) {

  $email = $_POST['email'];

  // Recupero l'utente appena creato dal database

  $sql = "SELECT * FROM utenti WHERE email = '". $email . "' ";
    
  $result = $mysqli->query($sql);

  $user = $result->fetch_assoc();

  // Avvio una sessione

  session_start();
  
  // Rigenera l'ID di sessione

  session_regenerate_id();
  
  // Memorizzo l'ID dell'utente nella sessione

  $_SESSION["user_id"] = $user["id"];

  // Memorizzo l'ID dell'utente nella sessione

  header("Location:user-events.php");
  exit;

} else {

  // Verifico se la mail inserita è gia presente in database

 if($mysqli->errno === 1062) {

  die("Email already taken");

 } else {

  die($mysqli->error . " " . $mysqli->errno);

 }
}