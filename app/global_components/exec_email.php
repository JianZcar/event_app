<?php

// When we use the gmail as sender
define("MAIL_HOST", "smtp.gmail.com");

require_once "./../../vendor/autoload.php";
require_once "./../../proj_info.php";
include_once "formatter.php";           // Date formatting
include_once "account.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function mail_sender($post_id, $senderName, $receiverEmail, $receiverName, $subject_name, $message, $attachments = [])
{
  global $db_conn;
  global $senderEmail, $senderPWD;

  // Sample credentials
  $senderEmail = "marcsysman@gmail.com";
  $senderPWD = "zildknxuucsswclo";

  // Ensure senderEmail and senderPWD are set and not empty
  if (empty($senderEmail) || empty($senderPWD)) {
    throw new Exception("Sender email or password is not set.");
  }

  $mail = new PHPMailer(true);

  try {
    $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output else comment it
    $mail->isSMTP();
    $mail->Host = MAIL_HOST;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->SMTPAuth = true;
    $mail->Username = $senderEmail;
    $mail->Password = $senderPWD;
    $mail->Port = 587;

    // Recipients
    $mail->setFrom($senderEmail, $senderName);
    $mail->addAddress($receiverEmail, $receiverName);
    $mail->addReplyTo($senderEmail, 'Information');
    $mail->addCC($senderEmail);
    $mail->addBCC($senderEmail);

    // Attachments
//    foreach ($attachments as $attachment) {
//      $mail->addAttachment($attachment);
//    }

    // Get start_datetime and end_datetime from post_id
    $sql = "SELECT start_datetime, end_datetime FROM event_posts WHERE id = ?";
    $stmt = $db_conn->prepare($sql);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();


//    date_format(date_create($start_datetime), "F d, Y h:i A")
    $start_datetime = $row['start_datetime'];
    $end_datetime = $row['end_datetime'];

    // Content
    $mail->isHTML(true);
    $mail->Subject = $subject_name;

    // Add start and end before the message with newline characters
    $mail->Body = "Event Start: " . date_format(date_create($start_datetime), "F d, Y h:i A") . "<br>Event End: " . date_format(date_create($end_datetime), "F d, Y h:i A") . "<br><br>\n" . $message;

    $mail->send();

    // Alert on javascript when send done
    echo "<script type='text/javascript'>alert('Message has been sent');</script>";
    session_announce("Message has been sent", true, "send_post.php?id=$post_id");
  } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }

  return TRUE;
}

?>