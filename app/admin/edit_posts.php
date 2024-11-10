<?php
session_start();
include_once "./../global_components/base.php";
web_start();

// Ensure $db_conn is initialized
global $db_conn;

// Custom componets
include "./../global_components/account.php";
include "./../global_components/set_posts.php";
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
  $start_datetime = date("Y-m-d H:i:s", strtotime("$start_date $start_time"));
  $end_datetime = date("Y-m-d H:i:s", strtotime("$end_date $end_time"));

  $send_post['subject_name'] = $subject_name;
  $send_post['start_datetime'] = $start_datetime;
  $send_post['end_datetime'] = $end_datetime;
  $send_post['content'] = $content;

  // Edit post
  edit_post_update($post_id, $send_post, $_SESSION['user_id']);

} else {
  // Get information post
  check_post_exist($_GET['id']);

  $row = edit_post($_GET['id'], $_SESSION['user_id']);
  $post_id = (int) $_GET['id'];

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
    // unset($_SESSION['msg_account_announce']);
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php global_style(); ?>
  <title><?php echo $page_full_name ?></title>
  <?php global_first_js();?>
  <?php tinymce_js_init(); ?>
</head>

<body class="flex flex-row min-w-screen">

  <?php // Left sidebar ?>
  <div class="slide-panel" id="sidebar-content">
  <?php sidebar_init(); ?>
  </div>

  <?php // Main content ?>
  <div class="main-content">
  <!-- Header -->
  <header class="navigator-header btn-slide">
    <a class="p-2 text-2xl hover-action" id="btn-menu-list" onclick="slideOpen()"><i class='bx bx-menu'></i></a>
    <h1 class="p-2 text-2xl"><?php echo $page_full_name ?></h1>
  </header>

  <!-- Main Object -->
  <main class="flex flex-col w-full h-full m-h-screen">
    <?php if (isset($msg_account_announce)) : ?>
      <div class="p-base">
        <p><?php echo $msg_account_announce ?></p>
      </div>
    <?php endif; ?>
  <form method="post">
    <form method="post">
    <?php post_edit_subject_name($subject_name) ?>
    <?php post_edit_content($content, $start_datetime, $end_datetime, $updated_at) ?>
    <?php post_edit_actions($post_id) ?>
    </form>
  </form>
  </main>

  <?php global_footer($proj_name, $proj_version, $proj_author, $proj_current_year); ?>
  <?php global_last_js(); ?>  
  </div>

</body>

</html>
