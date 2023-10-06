<?php

// Carico il file di connessione al database

$mysqli = require __DIR__ . "./assets/db/database.php";

// Preparo la query SQL per selezionare l'utente con l'email fornita

$sql = sprintf("SELECT * FROM utenti
                WHERE email = '%s'",
                $mysqli->real_escape_string($_GET["email"]));

// Eseguo la query SQL

$result = $mysqli->query($sql);

// Verifico se l'utente esiste

$is_available = $result->num_rows === 0;

// Imposto il content type della risposta

header("Content-Type: application/json");

// Imposto il content type della risposta

echo json_encode(["available" => $is_available]);