<?php
  session_start();

  // Include the project information
  include "./../../proj_info.php";

  $page_name = "Admin Panel";
  $page_full_name = "$page_name | $proj_name";

  // Message Control
  if (isset($_SESSION['msg_account_announce'])) {
    $msg_account_announce = $_SESSION['msg_account_announce'];
    unset($_SESSION['msg_account_announce']);
  }

  // SQL Query
  $sql_cmd = <<<SQL

  SQL;

  // Execute the query
  $result_users = $db_conn->query($sql_users);

  // If other choice than above, use this
  // $sql_cmd = "SELECT * FROM users";
  // $result_users = $db_conn->query($sql_cmd);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../global_assets/css/output.css" rel="stylesheet">
  <link href="./../global_assets/css/global_footer.css" rel="stylesheet">
  <link href="./../global_assets/css/panel.css" rel="stylesheet">
  <link href="./../global_assets/css/sidebar.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body class="mainstream-panel">
  
<div class="bg-blue-500 sidebar-content" id="sidebar-content">
  <?php include_once './../global_assets/php/sidebar.php';?>
</div>

<div class="main-content">
  <header class="bg-blue-500 text-white p-4 p-base-nav">
    <div>
      <a class="btn-menu-list" id="btn-menu-list" onclick="toggleSidebar()"><i class='bx bx-menu'></i></a>
    </div>
    <div>
      <h1 class="text-2xl"><?php echo $page_full_name?></h1>
    </div>
  </header>

  <main class="p-4 p-body">
    <!-- Here the body -->
  </main>

  <footer class="bg-gray-800 text-white p-4 p-footer" id="p-footer">
    <p>All rights reserved <?php echo $proj_current_year?></p>
  </footer>
  <script src="./../global_assets/js/sidebar.js"></script>
</div>
</body>
</html>