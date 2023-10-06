<?php

class EventController
{
    private $events;

    public function __construct()
    {
        $this->events = [];
    }

    public function all()
    {
        return $this->events;
    }

    public function add(Event $event)
    {

        // Richiede il file di database

        $mysqli = require __DIR__ . "./assets/db/database.php";

        // Aggiunge l'evento all'array degli eventi

        $this->events[] = $event;

        // Preparo la query di inserimento dell'evento nel database

        $sql = "INSERT INTO eventi (attendees, nome_evento, data_evento) VALUES ('$event->attendees', '$event->title', '$event->date')";

        // // Creo una prepared statement

        $stmt = $mysqli->stmt_init();
        

        // Preparo la prepared statement con la query SQL

        if(!$stmt->prepare($sql)) {
            die("SQL error: " . $mysqli->error);
        }

        // $stmt->bind_param("ssss", $event->attendees, $event->title, $event->date);

        // Eseguo la prepared statement

        if($stmt->execute()) {

         // Creo un array degli invitati

         $attendees_array = explode(",", $event->attendees);

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
            l'evento <strong>$event->title</strong> si svolgera il <strong>$event->date</strong>.
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
    }

    public function edit(Event $event, $id)
    {

        // Aggiunge l'evento all'array degli eventi

        $mysqli = require __DIR__ . "./assets/db/database.php";

        // Aggiunge l'evento all'array degli eventi

        $this->events[] = $event;

        // Preparo la query di modifica dell'evento nel database

        $sql = "UPDATE eventi SET nome_evento = ?, attendees = ?, data_evento = ? WHERE id = ?";

        // Creo una prepared statement

        $stmt = $mysqli->stmt_init();

        // Verifico se la prepared statement può essere preparata

        if(!$stmt->prepare($sql)) {
         die("SQL error: " . $mysqli->error);
        }

        $attendees = trim($event->attendees);
        // Lego i parametri della prepared statement

        $stmt->bind_param("ssss", $event->title, $event->attendees, $event->date, $id);

        // Eseguo la prepared statement

        if($stmt->execute()) {

         // Creo un array degli invitati

         $attendees_array = explode(",", $event->attendees);

         // Carico il file di configurazione del mailer

         $mail = require __DIR__ . "/mailer.php";

         // Invio un'email a ciascun invitato

         foreach ($attendees_array as $attendee) {

            // Imposto mittente, destinatario, oggeto e corpo dell'email

            $mail->setFrom("danielecorradotestmail@gmail.com");
            $mail->addAddress($attendee);
            $mail->Subject = "New Event";
            $mail->Body = <<<END

            l'evento <strong>$event->title</strong> che si svolger&agrave; il <strong>$event->date</strong>. Ha subito delle modifiche.
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
    }

    public function delete(Event $event, $id)
    {
        // Aggiunge l'evento all'array degli eventi

        $mysqli = require __DIR__ . "./assets/db/database.php";

        // Aggiunge l'evento all'array degli eventi

        $this->events[] = $event;


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

        if($stmt->execute()) {

         // Creo un array degli invitati

         $attendees_array = explode(",", $event->attendees);

         // Carico il file di configurazione del mailer

         $mail = require __DIR__ . "/mailer.php";

         // Invio un'email a ciascun invitato

         foreach ($attendees_array as $attendee) {

            // Imposto mittente, destinatario, oggeto e corpo dell'email

            $mail->setFrom("danielecorradotestmail@gmail.com");
            $mail->addAddress($attendee);
            $mail->Subject = "New Event";
            $mail->Body = <<<END

            Ti informiamo che l'evento <strong>$event->title</strong>
            che si sarebbe dovuto svolgere il <strong>$event->date</strong>
            è stato cancellato. <br>
            
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
    }
}