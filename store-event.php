<?php

$mysqli = require __DIR__ . "./assets/db/database.php";

$attendees = $_POST['attendees'];
$name = $_POST['name'];
$date = $_POST['date'] . " " . $_POST['time'];

// Prepara la query di inserimento

$sql = "INSERT INTO eventi (attendees, nome_evento, data_evento) VALUES ('$attendees', '$name', '$date')";

$stmt = $mysqli->stmt_init();

$stmt = $mysqli->prepare($sql);

if($stmt->execute()) {

 $attendees_array = explode(",", $attendees);

 $mail = require __DIR__ . "/mailer.php";

 foreach ($attendees_array as $attendee) {
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

        $mail->send();

    } catch (Exception $e) {

        echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";

    }
 }


 header("Location:user-events.php");
 echo "event added successfully";
 exit;

} 

