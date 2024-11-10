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

// Prepare the query
$sql_cmd = "SELECT 
            subject_name, 
            id, 
            content, 
            start_datetime, 
            end_datetime, 
            created_at, 
            updated_at 
        FROM 
            event_posts 
        WHERE 
            id = ?";

$stmt = $db_conn->prepare($sql_cmd);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if post exists
if ($result->num_rows === 0) {
  session_announce("Post not found.", true, "./posts.php");
  exit;
}

$row = $result->fetch_assoc();

// Format dates
$post_id = $row['id'];
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php global_style(); ?>
  <title><?php echo $page_full_name ?></title>
  <?php global_first_js(); ?>
</head>

<body class="flex flex-row min-w-screen">

  <?php // Left sidebar ?>
  <div class="slide-panel" id="sidebar-content">
    <?php sidebar_init(); ?>
  </div>

  <?php // Main content ?>
  <div class="main-content">

    <?php global_header($page_full_name, $proj_name); ?>

    <!-- Main Object -->
    <main class="flex flex-col w-full h-full m-h-screen">
      <?php if (isset($msg_account_announce)) : ?>
        <div class="p-base">
          <p><?php echo $msg_account_announce ?></p>
        </div>
      <?php endif; ?>

      <?php post_subject_name($subject_name, $post_status, $created_at); ?>

      <div class="p-base">
        <?php post_content($content, $start_datetime, $end_datetime, $updated_at); ?>
        <?php post_actions($post_id) ?>
      </div>

      <?php post_actions_2($post_id) ?>
    </main>

    <?php global_footer($proj_name, $proj_version, $proj_author, $proj_current_year); ?>
    <?php global_last_js(); ?>
  </div>

</body>

</html>