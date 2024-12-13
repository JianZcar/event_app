<?php
session_start();
include_once "./../global_components/base.php";
web_start();

// Ensure $db_conn is initialized
global $db_conn;

// Custom componets
include_once "./../global_components/account.php";
include_once "./../global_components/set_posts.php";
include_once "./../global_components/post_components.php";
include_once "./../global_components/post_query.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get post data
  $subject_name = $_POST['subject_name'];
  $start_date = $_POST['start_date'];
  $start_time = $_POST['start_time'];
  $end_date = $_POST['end_date'];
  $end_time = $_POST['end_time'];
  $content = $_POST['content'];
  $post_id = $_GET['id'];

  // Combine date and time
  $start_datetime = merge_datetime($start_date, $start_time);
  $end_datetime = merge_datetime($end_date, $end_time);

  $send_post['subject_name'] = $subject_name;
  $send_post['start_datetime'] = $start_datetime;
  $send_post['end_datetime'] = $end_datetime;
  $send_post['content'] = $content;

  // Handle file uploads
  $attachments = [];
  if (!empty($_FILES['attachments']['name'][0])) {
    foreach ($_FILES['attachments']['tmp_name'] as $key => $tmp_name) {
      $file_name = $_FILES['attachments']['name'][$key];
      $file_tmp = $_FILES['attachments']['tmp_name'][$key];
      $file_content = file_get_contents($file_tmp);
      $attachments[] = [
        'name' => $file_name,
        'content' => $file_content
      ];
    }
  }

  // Save attachments to the database
  foreach ($attachments as $attachment) {
    $sql_cmd = "INSERT INTO event_post_attachments (post_id, attachment, created_at) VALUES (?, ?, NOW())";
    $stmt = $db_conn->prepare($sql_cmd);
    $stmt->bind_param("is", $post_id, $attachment['content']);
    $stmt->execute();
  }

  // Handle removed attachments
  if (!empty($_POST['removed_attachments'])) {
    $removed_attachments = explode(',', rtrim($_POST['removed_attachments'], ','));
    foreach ($removed_attachments as $attachment_id) {
      $sql_cmd = "DELETE FROM event_post_attachments WHERE id = ?";
      $stmt = $db_conn->prepare($sql_cmd);
      $stmt->bind_param("i", $attachment_id);
      $stmt->execute();
    }
  }

  // Edit post
  edit_post_update($post_id, $send_post, $_SESSION['user_id']);
}else {

  // Get information post
  check_post_exist($_GET['id']);

  $row = edit_post($_GET['id'], $_SESSION['user_id']);
  $post_id = (int)$_GET['id'];


  // Format dates
  $subject_name = $row['subject_name'];
  $content = $row['content'];
  $start_datetime = date_format(date_create($row['start_datetime']), "F d, Y h:i A");
  $end_datetime = date_format(date_create($row['end_datetime']), "F d, Y h:i A");
  $updated_at = date_format(date_create($row['updated_at']), "F d, Y h:i A");
  $created_at = date_format(date_create($row['created_at']), "F d, Y h:i A");

  // Determine post status
  $post_status = date_status($start_datetime, $end_datetime);

  // Set page variables
  $page_name = "Admin Panel";
  $page_full_name = page_full_name();

  // Display announcement message
  if (isset($_SESSION['msg_account_announce'])) {
    $msg_account_announce = $_SESSION['msg_account_announce'];
    unset($_SESSION['msg_account_announce']);
  }

  // Attachment load
  $attachments = [];
  $sql_cmd = "SELECT id, attachment FROM event_post_attachments WHERE post_id = ?";
  $stmt = $db_conn->prepare($sql_cmd);
  $stmt->bind_param("i", $post_id);
  $stmt->execute();
  $result = $stmt->get_result();
  while ($row = $result->fetch_assoc()) {
    $attachments[] = $row;
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php global_style(); ?>
  <title><?php echo $page_full_name ?></title>
  <?php global_first_js(); ?>
  <?php tinymce_js_init(); ?>
</head>
<body class="b-body">
<?php // Left sidebar ?>
<div class="slide-panel" id="sidebar-content">
  <?php sidebar_init(); ?>
</div>
<div class="main-content">
  <header class="navigator-header btn-slide">
    <a class="p-2 text-2xl hover-action" id="btn-menu-list" onclick="slideOpen()"><i class='bx bx-menu'></i></a>
    <h1 class="p-2 text-2xl"><?php echo $page_full_name ?></h1>
  </header>
  <main class="flex flex-col w-full h-full m-h-screen">
    <?php if (isset($msg_account_announce)) : ?>
      <div class="p-base">
        <p><?php echo $msg_account_announce ?></p>
      </div>
    <?php endif; ?>
<form method="post" enctype="multipart/form-data">
  <?php post_edit_subject_name($subject_name) ?>
  <?php post_edit_content($content, $start_datetime, $end_datetime) ?>
  <div class="p-base">
    <label for="attachments">Attachments:</label>
    <div id="file-inputs">
      <?php foreach ($attachments as $attachment) : ?>
        <div id="attachment-<?php echo $attachment['id']; ?>">
          <a href="download_attachment.php?id=<?php echo $attachment['id']; ?>">Download</a>
          <button type="button" onclick="removeAttachment(<?php echo $attachment['id']; ?>)">Remove</button>
        </div>
      <?php endforeach; ?>
      <input type="file" name="attachments[]">
    </div>
    <button type="button" onclick="addFileInput()">Add</button>
  </div>
  <input type="hidden" name="removed_attachments" id="removed_attachments">
  <?php post_edit_actions($post_id) ?>
</form>
  </main>
  <?php global_footer(); ?>
  <?php global_last_js(); ?>
</div>
</body>
<script>
  function addFileInput() {
    const newInput = document.createElement('input');
    newInput.type = 'file';
    newInput.name = 'attachments[]';
    document.getElementById('file-inputs').appendChild(newInput);

    const removeButton = document.createElement('button');
    removeButton.type = 'button';
    removeButton.innerText = 'Remove';
    removeButton.onclick = function() { removeFileInput(newInput, removeButton); };
    document.getElementById('file-inputs').appendChild(removeButton);
  }

  function removeFileInput(input, button) {
    document.getElementById('file-inputs').removeChild(input);
    document.getElementById('file-inputs').removeChild(button);
  }

  function removeAttachment(id) {
    const attachmentDiv = document.getElementById(`attachment-${id}`);
    attachmentDiv.parentNode.removeChild(attachmentDiv);

    const removedAttachments = document.getElementById('removed_attachments');
    removedAttachments.value += id + ',';
}
</script>
</html>