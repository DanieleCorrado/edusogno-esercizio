<?php

// Richiede i file event.php e eventController.php

require __DIR__ . "./event.php";
require __DIR__ . "./eventController.php";


// Recupera gli invitati, il nome e la data dell'evento dal POST

$attendees = $_POST['attendees'];
$name = $_POST['name'];
$date = $_POST['date'] . " " . $_POST['time'];

// Crea un nuovo controller EventController

$eventController = new EventController();

// Crea un nuovo oggetto Event

$event = new Event($name, $attendees, $date);

// Aggiunge l'evento al database

$eventController->add($event);

