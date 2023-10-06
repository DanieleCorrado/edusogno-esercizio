<?php


require __DIR__ . "./event.php";
require __DIR__ . "./eventController.php";


// Recupero i dati dell'evento dal post

$attendees = $_POST['attendees'];
$name = $_POST['name'];
$date = $_POST['date'] . " " . $_POST['time'];

$eventController = new EventController();

$event = new Event($name, $attendees, $date);

$eventController->add($event);

