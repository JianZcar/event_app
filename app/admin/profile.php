<?php
session_start();
include_once "./../global_components/base.php";
web_start();

// Custom componets
include_once "./../global_components/profile_componets.php";
$page_name = "Profile";
$page_full_name = page_full_name();

// Message Control
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

  <!-- Left Sidebar -->
  <div class="slide-panel" id="sidebar-content">
    <?php sidebar_init(); ?>
  </div>

  <!-- Rest is main content -->
  <!-- Main Content -->
  <div class="main-content">
    <!-- Header -->
    <header class="navigator-header btn-slide">
      <a class="p-2 text-2xl hover-action" id="btn-menu-list" onclick="slideOpen()"><i class='bx bx-menu'></i></a>
      <h1 class="p-2 text-2xl"><?php echo $page_full_name ?></h1>
    </header>

    <!-- Main Object -->
    <main class="flex flex-col w-full h-full m-h-screen">

      <?php profile_card(); ?>

      <div class="p-base">
        <p>What would you like to do today?</p>
      </div>
    </main>

    <?php 
    global_footer();
    global_last_js(); ?>
  </div>

</body>

</html>