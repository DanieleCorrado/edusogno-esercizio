<?php

// Verifico se l'ID dell'evento è stato fornito

if (!isset($_POST['id'])) {
        // Se l'ID dell'evento non è stato fornito, reindirizzo l'utente alla dashboard

    header("Location: dashboard.php");
    exit;
}

// Carico il file di connessione al database

$mysqli = require __DIR__ . "./assets/db/database.php";

// Acquisisco l'ID dell'evento

$id = $_POST['id'];

// Creo la query SQL per eliminare l'evento

 $sql = "DELETE FROM eventi WHERE id = $id";

 // Inizializzo la prepared statement

 $stmt = $mysqli->stmt_init();

// Preparo la query SQL

 if(!$stmt->prepare($sql)) {
    // Se la query SQL non può essere preparata, stampo un errore e termino l'esecuzione dello script
  die("SQL error: " . $mysqli->error);
 }

// Eseguo la prepared statement

 $result = $stmt->execute();

// Eseguo la prepared statement

 header("Location: dashboard.php");
 exit;

?>
