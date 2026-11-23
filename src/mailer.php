<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php' ;

function sendMail(string $to, string $subject, string $body) : bool
{

    $config = require __DIR__ . '/../config/config.php' ;
    $mailConfig = $config['mail'] ;

    $mail = new PHPMailer(true) ;

    try {
        $mail->isSMTP();
        $mail->Host = $mailConfig['host'];
        $mail->Port = $mailConfig['port'] ;
        $mail->SMTPAuth = true;
        $mail->Username = $mailConfig['username'];
        $mail->Password = $mailConfig['password'];
        $mail->CharSet = 'UTF-8';

        $mail->setFrom($mailConfig['from_email'], $mailConfig['from_name']) ;
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log('Erreur email : ' . $mail->ErrorInfo) ;
        return false ;
    }


}