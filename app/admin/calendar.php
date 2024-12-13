<?php
session_start();
include_once "./../global_components/base.php";
web_start();

// Custom componets
include_once "./../global_components/calendar_mod.php";
include_once "./../global_components/calendar_components.php";
// Page Info
$page_name = "Calendar";
$page_full_name = page_full_name();

// Message Control
if (isset($_SESSION['msg_account_announce'])) {
  $msg_account_announce = $_SESSION['msg_account_announce'];
  unset($_SESSION['msg_account_announce']);
}

// Query calendar data
$event_data = get_events();


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php global_style(); ?>
  <title><?php echo $page_full_name ?></title>
  <?php 
  global_first_js();
  import_jquery();
  calendar_init_script();
  ?>
  
</head>

<body class="b-body">

  <!-- Left Sidebar -->
  <div class="slide-panel" id="sidebar-content">
    <?php sidebar_init(); ?>
  </div>

  <!-- Rest is main content -->
  <div class="flex flex-col w-screen max-w-screen min-h-screen">

    <!-- Header -->
    <?php global_header($page_full_name); ?>

    <!-- Main Object -->
    <main class="main-content">

      <?php system_message('Heres the incoming event.'); ?>

      <div class="p-base flex flex-col md:flex-row">

        <!-- <?php upcoming_event_show($event_data); ?> -->

        <div class="flex flex-col w-full">
          <div class="p-calendar" id="calendar"></div>
        </div>
      </div>

    </main>

    <?php 
    calendar_init();
    global_footer();
    global_last_js(); ?>
  </div>

</body>

</html>