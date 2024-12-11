<?php
session_start();
include_once "./../global_components/base.php";
web_start();

// Custom componets
include_once "./../global_components/account.php";
include_once "./../global_components/post_components.php";
include_once "./../global_components/post_query.php";

// Get information post
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  session_announce("Invalid post ID.", true, "./posts.php");
  exit;
}

$post_id = (int) $_GET['id'];

$row = view_post($post_id, $_SESSION['user_id']);

$post_status = $row['post_status'];
$subject_name = $row['subject_name'];
$content = $row['content'];
$start_datetime = date_format(date_create($row['start_datetime']), "F d, Y h:i A");
$end_datetime = date_format(date_create($row['end_datetime']), "F d, Y h:i A");
$updated_at = date_format(date_create($row['updated_at']), "F d, Y h:i A");
$created_at = date_format(date_create($row['created_at']), "F d, Y h:i A");

// Set page variables
$page_name = "Admin Panel";
$page_full_name = page_full_name();

// Display announcement message
if (isset($_SESSION['msg_account_announce'])) {
  $msg_account_announce = $_SESSION['msg_account_announce'];
  unset($_SESSION['msg_account_announce']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php global_style(); ?>
  <title><?php echo $page_full_name ?></title>
  <?php global_first_js(); ?>
</head>

<body class="b-body">

  <?php // Left sidebar ?>
  <div class="slide-panel" id="sidebar-content">
    <?php sidebar_init(); ?>
  </div>

  <?php // Main content ?>
  <div class="main-content">

    <?php global_header($page_full_name, $proj_name); ?>

    <main class="flex flex-col w-full h-full m-h-screen">
      <?php if (isset($msg_account_announce)) : ?>
        <div class="p-base">
          <p><?php echo $msg_account_announce ?></p>
        </div>
      <?php endif; ?>

      <?php post_subject_name($subject_name, $post_status, $created_at); ?>

      <div class="p-base">
        <?php post_content($start_datetime, $end_datetime, $content); ?>
        <?php post_actions($post_id) ?>
      </div>

      <?php post_actions_2($post_id) ?>
    </main>

    <?php global_footer(); ?>
    <?php global_last_js(); ?>
  </div>
</body>
</html>