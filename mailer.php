<?php

// Importa le librerie PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Carica le librerie PHPMailer dal vendor

require __DIR__ . "/vendor/autoload.php";

// Crea una nuova istanza di PHPMailer

$phpmailer = new PHPMailer(true);

$phpmailer->isSMTP();
$phpmailer->SMTPAuth = true;
$phpmailer->Host = 'smtp.gmail.com';
$phpmailer->Username = 'danieleCorradotestmail@gmail.com';
$phpmailer->Password = 'sxljiessiobmtznx';
$phpmailer->SMTPSecure = "tls";
$phpmailer->Port = 587;

$phpmailer->isHtml(true);

return $phpmailer;