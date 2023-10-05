<?php

 $email = $_POST["email"];

 $token = bin2hex(random_bytes(16));

 $token_hash = hash("sha256", $token);


 $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

 $mysqli = require __DIR__ . "/assets/db/database.php";

 $sql = "UPDATE utenti
         SET reset_token = ?,
             reset_token_expire_at = ?
         WHERE email = ?";

 $stmt = $mysqli->prepare($sql);

$stmt->bind_param("sss", $token_hash, $expiry, $email);

$stmt->execute();

if ($mysqli->affected_rows) {

    $mail = require __DIR__ . "/mailer.php";

    $mail->setFrom("danielecorradotestmail@gmail.com");
    $mail->addAddress($email);
    $mail->Subject = "Password Reset";
    $mail->Body = <<<END

    Click <a href="http://localhost/reset-password.php?token=$token">here</a> 
    to reset your password.

    END;

    try {

        $mail->send();

    } catch (Exception $e) {

        echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";

    }

}

header("Location:index.php");
 