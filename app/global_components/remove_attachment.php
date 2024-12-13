<?php
session_start();
include_once "./../global_components/base.php";
global $db_conn;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $attachment_id = $_POST['id'];

  // Delete the attachment from the database
  $sql_cmd = "DELETE FROM event_post_attachments WHERE id = ?";
  $stmt = $db_conn->prepare($sql_cmd);
  $stmt->bind_param("i", $attachment_id);
  $success = $stmt->execute();

  // Return JSON response
  header('Content-Type: application/json');
  echo json_encode(['success' => $success]);
}
?>