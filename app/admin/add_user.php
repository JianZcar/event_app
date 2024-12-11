<?php
session_start();
include_once "./../global_components/base.php";
web_start();

// Custom componets
include_once "./components/module.php";
include_once "./../global_components/account.php";

// Page Info
$page_name = "Add User";
$page_full_name = page_full_name();
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
  <div class="flex flex-col w-screen max-w-screen min-h-screen">
    <?php global_header($page_full_name, $proj_name); ?>
    <main class="main-content">
    <?php 
      if (isset($msg_account_announce)) {
        msg_account_announce($msg_account_announce);
        unset($msg_account_announce);
      }
    ?>
    <?php form_user_add()?>
    </main>
    <?php global_footer(); ?>
    <?php global_last_js(); ?>
  </div>
</body>
</html>