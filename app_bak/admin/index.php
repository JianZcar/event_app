<?php
  session_start();
  include "./../../proj_info.php";

  $page_name = "Admin Panel";
  $page_full_name = "$page_name | $proj_name";

  // Message Control
  if (isset($_SESSION['msg_account_announce'])) {
    $msg_account_announce = $_SESSION['msg_account_announce'];
    unset($_SESSION['msg_account_announce']);
  }

  $sql_users = <<<SQL
  SELECT 
      users.id,
      users.username, 
      users.is_active, 
      user_roles.role_name,
      user_roles.color,
      user_roles.bg_color
  FROM 
      users 
  INNER JOIN 
      user_roles 
  ON 
      users.user_role = user_roles.id
  ORDER BY 
      users.id;
  SQL;
  // echo $sql_users;
  $result_users = $db_conn->query($sql_users);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../global_assets/css/output.css" rel="stylesheet">
  <link href="./../global_assets/css/global_footer.css" rel="stylesheet">
  <!-- <link href="./../global_assets/css/panel.css" rel="stylesheet"> -->
  <!-- <link href="./../global_assets/css/sidebar.css" rel="stylesheet"> -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body class="mainstream-panel">

<div class="bg-blue-500 sidebar-content" id="sidebar-content">
  <?php include_once './../global_assets/php/sidebar.php';?>
</div>

<div class="main-content">
  <!-- <header class="bg-blue-500 text-white p-4 p-base-nav"> -->
  <header class="bg-blue-500 text-white p-4 p-base-nav">
    <div>
      <a class="btn-menu-list" id="btn-menu-list" onclick="toggleSidebar()"><i class='bx bx-menu'></i></a>
    </div>
    <div>
      <h1 class="text-2xl"><?php echo $page_full_name?></h1>
    </div>
  </header>

  <main class="p-4 p-body">
    <div class="panel-base p-title">
      <h1>Welcome back, Administrator!</h1>
    </div>
    <div class="panel-base">
      <h1>Navigate where you want to go.</h1>
    </div>
  </main>
  <footer class="bg-gray-800 text-white p-4 p-footer" id="p-footer">
    <p>All rights reserved <?php echo $proj_current_year?></p>
  </footer>
  <script src="./../global_assets/js/sidebar.js"></script>
</div>
</body>
</html>