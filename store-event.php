<?php

// Carico il file di connessione al database

$mysqli = require __DIR__ . "./assets/db/database.php";

// Recupero i dati dell'evento dal post

$attendees = $_POST['attendees'];
$name = $_POST['name'];
$date = $_POST['date'] . " " . $_POST['time'];

// Preparo la query di inserimento dell'evento nel database

$sql = "INSERT INTO eventi (attendees, nome_evento, data_evento) VALUES ('$attendees', '$name', '$date')";

// Creo una prepared statement

$stmt = $mysqli->stmt_init();

// Preparo la prepared statement con la query SQL

$stmt = $mysqli->prepare($sql);

// Eseguo la prepared statement

if($stmt->execute()) {

 // Creo un array degli invitati

 $attendees_array = explode(",", $attendees);

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

// Reindirizzo l'utente alla pagina user-events.php

 header("Location:user-events.php");
 exit;

} 

