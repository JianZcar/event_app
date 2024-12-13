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

function mail_sender($post_id, $senderName, $receiverEmail, $receiverName, $subject_name, $message)
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
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output else comment it
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

    // Get start_datetime and end_datetime from post_id
    $sql = "SELECT start_datetime, end_datetime FROM event_posts WHERE id = ?";
    $stmt = $db_conn->prepare($sql);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
      $start_datetime = $row['start_datetime'];
      $end_datetime = $row['end_datetime'];

      // Content
      $mail->isHTML(true);
      $mail->Subject = $subject_name;

      // Add start and end before the message with newline characters
      $mail->Body = "Event Start: " . date_format(date_create($start_datetime), "F d, Y h:i A") . "<br>Event End: " . date_format(date_create($end_datetime), "F d, Y h:i A") . "<br><br>\n" . $message;

      // Fetch attachment from the database
      $sql = "SELECT id, attachment, ext FROM event_app.event_post_attachments WHERE post_id = ?";
      $stmt = $db_conn->prepare($sql);
      $stmt->bind_param("i", $post_id);
      $stmt->execute();
      $result = $stmt->get_result();

      while ($row = $result->fetch_assoc()) {
        $file_id = $row['id'];
        $file_data = $row['attachment'];
        $ext = $row['ext'];

        // Ensure the /upload directory exists
        $upload_dir = __DIR__ . "\\upload\\";
        if (!is_dir($upload_dir)) {
          mkdir($upload_dir, 0777, true);
        }

        // Save the file to the /upload directory
        $file_path = $upload_dir . $file_id;
        $file_path = $file_path . "." . $ext;
        if (file_put_contents($file_path, $file_data) === false) {
          throw new Exception("Failed to save file: $file_path");
        }

        // Attach the file
        if (!$mail->addAttachment($file_path)) {
          throw new Exception("Failed to attach file: $file_path");
        }
      }

      $mail->send();

      // Reverse operation: delete the downloaded file
      if (file_exists($file_path)) {
        unlink($file_path);
      }


      // Alert on javascript when send done
      echo "<script type='text/javascript'>alert('Message has been sent');</script>";
      session_announce("Message has been sent", true, "send_post.php?id=$post_id");
    } else {
      throw new Exception("No event found for post_id: $post_id");
    }
  } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }

  return TRUE;
}

?>