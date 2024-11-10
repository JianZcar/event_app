<?php
session_start();
include_once "./../global_components/base.php";
web_start();

// Custom componets
include_once "./components/module.php";
include "./../global_components/account.php";

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

<body class="flex flex-row min-w-screen">

  <!-- Left Sidebar -->
  <div class="slide-panel" id="sidebar-content">
    <?php sidebar_init(); ?>
  </div>

  <!-- Main Content -->
  <div class="flex flex-col w-screen max-w-screen min-h-screen">
    <!-- Header -->
    <header class="navigator-header btn-slide">
      <a class="p-2 text-2xl hover-action" id="btn-menu-list" onclick="slideOpen()"><i class='bx bx-menu'></i></a>
      <h1 class="p-2 text-2xl"><?php echo $page_full_name ?></h1>
    </header>

    <!-- Main Object -->
    <main class="main-content">

      <?php
      // Display the message
      if (isset($msg_account_announce)) {
        echo "<div class='p-base'><p>$msg_account_announce</p></div>";
        unset($_SESSION['msg_account_announce']);
      }
      ?>

      <?php form_user_edit($db_conn)?>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white p-4 p-footer" id="p-footer">
      <p>All rights reserved <?php echo $proj_current_year ?></p>
    </footer>

    <script src="./../global_assets/js/sidebar.js"></script>
  </div>

</body>

</html>