<?php
// Avvia una sessione

session_start();

// Distrugge la sessione

session_destroy();

// Reindirizza l'utente alla pagina index.php

header("Location: index.php");
exit;