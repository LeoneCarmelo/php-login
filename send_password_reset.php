<?php
require './vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include("server.php");
require 'config.php';

$mail = new PHPMailer(true);//with true we activate the exceptions

$email = $_POST["email"];

/* Before write the code below
add 2 columns in the database 
reset_token_hash VARCHAR(64) NULL default NULL UNIQUE INDEX
reset_token_expires_at DATETIME NULL default NULL
*/

//Generate random token that it will be on the url
$token = bin2hex(random_bytes(16));
//For extra security the token will be hashed before is sent to the database
$hash_token = password_hash($token, PASSWORD_DEFAULT);
/* 
Generate an expiry for the token to make it valide just for a preset time.
In this case 30 minutes
*/
$expiry = date("Y-m-d H:i:s", strtotime('+30 minutes'));

$query = "UPDATE utenti 
          SET reset_token_hash = '$hash_token', reset_token_expires_at = '$expiry' 
          WHERE email = '$email'";

$result = mysqli_query($connection, $query);

if ($result) {
    try{
        
        //Set email server
        $mail->isSMTP();
        $mail->Host = 'smtp.mailgun.org';
        $mail->SMTPAuth = true;
        $mail->Port = 587;
        $mail->Username  = $username_mailgun;
        $mail->Password = $new_pass;
        
        //Set sender and receiver
        $mail->setFrom('info@edusogno.com', 'Edusogno'); // Mittente
        $mail->addAddress($email, 'Nome Destinatario'); // Destinatario
        
        // Email content
        $resetLink = "http://localhost/PHP/edusogno-esercizio/reset-password.php?token=$token&email=$email" . $token; // Replace with your reset password link
        //Define message
        $message = 'Click <a href="' . $resetLink . '">Here</a> to reset your password.';
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset';
        $mail->Body = $message;

        //Send the email
        $mail->send();
        //Show a message if everything went good
        $_SESSION['success_message'] =  "Ti abbiamo inviato un'email con le istruzioni per reimpostare la password.";
        header("Location: login.php");


    } catch(Exception $e) {
        echo "Errore nell'invio della mail: {$mail->ErrorInfo}";
    }
}  else {
    echo "Errore nell'aggiornamento del token nel database: " . $connection->$e->getMessage();
}