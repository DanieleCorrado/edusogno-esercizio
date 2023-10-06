<?php

 // Recupero l'email dall'utente

 $email = $_POST["email"];

 // Genero un token random di 16 caratteri

 $token = bin2hex(random_bytes(16));

 // Creo un hash del token

 $token_hash = hash("sha256", $token);

// Imposto la data di scadenza del token

 $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

 // Carico il file di connessione al database

 $mysqli = require __DIR__ . "/assets/db/database.php";

 // Preparo la query SQL per aggiornare il token di reset della password dell'utente

 $sql = "UPDATE utenti
         SET reset_token = ?,
             reset_token_expire_at = ?
         WHERE email = ?";

// Creo una prepared statement

$stmt = $mysqli->prepare($sql);

// Lego i parametri della prepared statement

$stmt->bind_param("sss", $token_hash, $expiry, $email);

// Eseguo la prepared statement

$stmt->execute();

// Se l'utente è stato trovato, invio un'email di reset della password

if ($mysqli->affected_rows) {

    // Carico il file di configurazione del mailer

    $mail = require __DIR__ . "/mailer.php";

    // Imposto mittente, destinatario, oggeto e corpo dell'email
    $mail->setFrom("danielecorradotestmail@gmail.com");
    $mail->addAddress($email);
    $mail->Subject = "Password Reset";
    $mail->Body = <<<END

    Click <a href="http://localhost/reset-password.php?token=$token">here</a> 
    to reset your password.

    END;

    try {

        // Invio l'email

        $mail->send();

    } catch (Exception $e) {

        echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";

    }

}

// Reindirizzo l'utente alla pagina index.php

header("Location:index.php");
 