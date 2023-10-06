<?php

// Acquisisco token di reset password

$token = $_POST["token"];

// Hash del token

$token_hash = hash("sha256", $token);

// Carico il file di connessione al database

$mysqli = require __DIR__ . "./assets/db/database.php";

// Preparo la query SQL per selezionare l'utente con il token fornito

$sql = "SELECT * FROM utenti WHERE reset_token = ?";

// Creo una prepared statement

$stmt = $mysqli->prepare($sql);

// Lego il parametro del token hash alla prepared statement

$stmt->bind_param("s", $token_hash);

// Eseguo la prepared statement

$stmt->execute();

// Recupero il risultato della query

$result = $stmt->get_result();

// Recupero l'utente dal risultato della query

$user = $result->fetch_assoc();

// Se l'utente non esiste, stampo un messaggio di errore e termino l'esecuzione dello script

if($user === null) {
 die("token not found");
}

// Verifico se il token è scaduto

if(strtotime($user["reset_token_expire_at"]) <= time()) {
 die("token has expired");
}

// Validazione password

if (strlen($_POST["password"]) < 8) {
 die("Password must be at least 8 characters");
}

if (!preg_match("/[a-z]/i", $_POST["password"])) {
 die("Password must contain at least one letter");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");
}

// Creo un hash della password

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

// Preparo la query SQL per aggiornare la password dell'utente

$sql = "UPDATE utenti
        SET reset_token = NULL,
            password = ?,
            reset_token_expire_at = NULL
        WHERE id = ?";

// Creo una prepared statement

$stmt = $mysqli->prepare($sql);

// Lego i parametri del hash della password e dell'ID dell'utente alla prepared statement

$stmt->bind_param("ss", $password_hash, $user["id"]);

// Eseguo la prepared statement

$stmt->execute();

// Reindirizzo l'utente alla pagina index.php

header("Location:index.php");

?>