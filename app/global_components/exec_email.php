<?php

// When we use the gmail as sender
define("MAIL_HOST", "smtp.gmail.com");

require "./../../vendor/autoload.php";
require "./../../proj_info.php";
include_once "account.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function mail_sender($post_id, $enderName,
                    $receiverEmail, $receiverName,
                    $subject_name, $message,
                    $attachment) {

    global $db_conn;
    global $senderEmail, $senderPWD;
    $mail = new PHPMailer(true);

    try {
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                  //Enable verbose debug output else comment it
        $mail->isSMTP();
        $mail->Host = MAIL_HOST;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->SMTPAuth = true;
        $mail->Username = $senderEmail;
        $mail->Password = $senderPWD;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom($senderEmail, 'Test mail by master');
        $mail->addAddress($receiverEmail, $receiverName);
        $mail->addReplyTo($senderEmail, 'Information');
        $mail->addCC($senderEmail);
        $mail->addBCC($senderEmail);

        // Attachments
        if (!empty($attachment)) {
            $mail->addAttachment($attachment);
        }

        // Content
        $mail->isHTML(true);

        $mail->Subject = $subject_name;
        $mail->Body = $message;

        $mail->send();

        // alert on javascript when send done
        echo "<script type='text/javascript'>alert('Message has been sent');</script>";
        session_announce("Message has been sent", true, "send_post.php?id=$post_id");
        // echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

}


?>


