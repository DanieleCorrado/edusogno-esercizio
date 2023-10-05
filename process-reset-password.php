<?php

$token = $_POST["token"];

$token_hash = hash("sha256", $token);

$mysqli = require __DIR__ . "./assets/db/database.php";

$sql = "SELECT * FROM utenti WHERE reset_token = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if($user === null) {
 die("token not found");
}

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

// Hashing password

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$sql = "UPDATE utenti
        SET reset_token = NULL,
            password = ?,
            reset_token_expire_at = NULL
        WHERE id = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("ss", $password_hash, $user["id"]);

$stmt->execute();

header("Location:index.php");

?>