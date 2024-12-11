<?php
session_start();
include_once "./../global_components/base.php";
include_once "./../login/components/exec_auth.php";
web_start();

// Custom componets
include_once "./../global_components/account.php";

// check authenicate
session_auth_daemon();

// Page Info
$page_name = "Admin Panel";
$page_full_name = page_full_name();

// Message Control
if (isset($_SESSION['msg_account_announce'])) {
  $msg_account_announce = $_SESSION['msg_account_announce'];
  unset($_SESSION['msg_account_announce']);
}
$load_username = $_SESSION['username'];
$load_user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php global_style(); ?>
  <title><?php echo $page_full_name ?></title>
  <?php global_first_js();?>
</head>
<body class="b-body">
  <div class="slide-panel" id="sidebar-content">
    <?php sidebar_init(); ?>
  </div>
  <div class="main-content">
    <?php global_header($page_full_name, $proj_name); ?>
    <main class="flex flex-col w-full h-full m-h-screen">
      <?php system_message_bold("Welcome back $load_username"); ?>
      <?php system_message("What would you like to do today?"); ?>
    </main>
    <?php global_footer(); ?>
    <?php global_last_js(); ?>
  </div>

</body>

</html>