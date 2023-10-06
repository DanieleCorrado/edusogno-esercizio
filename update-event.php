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

$attendees = trim($_POST["attendees"]);
// Lego i parametri della prepared statement

$stmt->bind_param("ssss", $_POST["name"], $attendees, $date, $_POST["id"]);

// Eseguo la prepared statement

if($stmt->execute()) {

 // Creo un array degli invitati

 $attendees_array = explode(",", $_POST["attendees"]);

 // Carico il file di configurazione del mailer

 $mail = require __DIR__ . "/mailer.php";

 // Invio un'email a ciascun invitato

 foreach ($attendees_array as $attendee) {

    // Imposto mittente, destinatario, oggeto e corpo dell'email

    $mail->setFrom("danielecorradotestmail@gmail.com");
    $mail->addAddress($attendee);
    $mail->Subject = "New Event";
    $mail->Body = <<<END

    &Egrave; stato aggiunto un nuovo evento in cui sei richiesto.
    <br>
    l'evento si svolgera il $_POST[date] alle $_POST[time].
    <br>
    Accedi al <a href="http://localhost">sito</a> 
    per maggiori informazioni.

    END;

    try {

        // Invio l'email

        $mail->send();

    } catch (Exception $e) {

        echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";

    }
   }

 // Reindirizzo l'utente alla pagina dashboard.php

 header("Location:dashboard.php");
 exit;

}