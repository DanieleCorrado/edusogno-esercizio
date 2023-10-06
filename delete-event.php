<?php

require __DIR__ . "./event.php";
require __DIR__ . "./eventController.php";

// Verifico se l'ID dell'evento è stato fornito

if (!isset($_POST['id'])) {
        // Se l'ID dell'evento non è stato fornito, reindirizzo l'utente alla dashboard

    header("Location: dashboard.php");
    exit;
}

print_r($_POST);

$attendees = $_POST['attendees'];
$name = $_POST['name'];
$date = $_POST['date'] . " " . $_POST['time'];

$eventController = new EventController();

$event = new Event($name, $attendees, $date);

$eventController->delete($event, $_POST['id']);


?>
