<?php

// Richiede i file event.php e eventController.php

require __DIR__ . "./event.php";
require __DIR__ . "./eventController.php";

// Verifico se l'ID dell'evento è stato fornito

if (!isset($_POST['id'])) {

    // Se l'ID dell'evento non è stato fornito, reindirizzo l'utente alla dashboard

    header("Location: dashboard.php");
    exit;
}

// Recupera gli invitati, il nome e la data dell'evento dal POST

$attendees = $_POST['attendees'];
$name = $_POST['name'];
$date = $_POST['date'] . " " . $_POST['time'];

// Crea un nuovo controller EventController

$eventController = new EventController();

// Crea un nuovo oggetto Event

$event = new Event($name, $attendees, $date);

// Elimina l'evento dal database

$eventController->delete($event, $_POST['id']);

?>
