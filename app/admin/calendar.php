<?php
session_start();
include_once "./../global_components/base.php";
web_start();

// Custom componets
include_once "./../global_components/calendar_mod.php";
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

<body class="flex flex-row min-w-screen">

  <!-- Left Sidebar -->
  <div class="slide-panel" id="sidebar-content">
    <?php sidebar_init(); ?>
  </div>

  <!-- Rest is main content -->
  <div class="flex flex-col w-screen max-w-screen min-h-screen">

    <!-- Header -->
    <?php global_header($page_full_name, $proj_name); ?>

    <!-- Main Object -->
    <main class="main-content">

      <?php system_message('Heres the incoming event.'); ?>

      <div class="p-base flex flex-col md:flex-row">
        <!-- about posts for event app -->
        <div class="flex flex-col w-full p-3">
          <p class="bold">Upcoming Events in 3 months</p>
          <div class="text-sm font-light text-[#6B7280] pb-8" bis_skin_checked="1">"Mark Your Calendars": Simplify date remembering.</div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-2
                      px-1 py-1" bis_skin_checked="1">
            <div class="upcoming-list" bis_skin_checked="1">test</div>
            <div class="upcoming-list" bis_skin_checked="1">test</div>
            <div class="upcoming-list" bis_skin_checked="1">test</div>
            <div class="upcoming-list" bis_skin_checked="1">test</div>
          </div>



        </div>

        <!-- Table -->
        <div class="flex flex-col w-full">
          <div class="p-calendar" id="calendar"></div>
        </div>
      </div>

    </main>

    <?php 
    calendar_init();
    global_footer($proj_name, $proj_version, $proj_author, $proj_current_year);
    global_last_js(); ?>
    <!-- <script src="./../global_assets/js/calendar.js"></script> -->
  </div>

</body>

</html>