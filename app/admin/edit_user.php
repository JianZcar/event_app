<?php
session_start();
include_once "./../global_components/base.php";
web_start();

// Custom components
include_once "./components/module.php";
include_once "./../global_components/account.php";

// Check if the id is set
check_user_exist($_GET['id']);

// Page Info
$page_name = "Edit User";
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
  <div class="main-content">
    <?php global_header($page_full_name, $proj_name); ?>
    <main class="flex flex-col w-full h-full m-h-screen">
      <?php
      // Display the message
      if (isset($_SESSION['msg_account_announce'])) {
        echo "<div class='p-base'><p>{$_SESSION['msg_account_announce']}</p></div>";
        unset($_SESSION['msg_account_announce']);
      }
      ?>
      <?php form_user_edit()?>
    </main>
    <?php global_footer(); ?>
    <?php global_last_js(); ?>
  </div>
</body>
</html>