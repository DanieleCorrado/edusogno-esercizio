<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . "/vendor/autoload.php";

// $mail = new PHPMailer(true);

// $mail->SMTPDebug = SMTP::DEBUG_SERVER;

// $mail->isSMTP();
// $mail->SMTPAuth = true;

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