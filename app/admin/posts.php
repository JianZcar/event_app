<?php
session_start();
include "./../../proj_info.php";

$page_name = "Posts";
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
  <title><?php echo $page_full_name ?></title>
  <link href="../global_assets/css/output.css" rel="stylesheet">
  <link href="./../global_assets/css/global_footer.css" rel="stylesheet">
  <!-- <link href="./../global_assets/css/panel.css" rel="stylesheet"> -->
  <!-- <link href="./../global_assets/css/sidebar.css" rel="stylesheet"> -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body class="flex flex-row min-w-screen">

  <!-- Left Sidebar -->
  <div class="slide-panel" id="sidebar-content">
    <?php include './../global_components/sidebar.php'; ?>
  </div>

  <!-- Rest is main content -->
  <!-- Main Content -->
  <div class="flex flex-col w-screen max-w-screen min-h-screen">
    <!-- Header -->
    <header class="navigator-header btn-slide">
      <a class="p-2 text-2xl hover-action" id="btn-menu-list" onclick="slideOpen()"><i class='bx bx-menu'></i></a>
      <h1 class="p-2 text-2xl"><?php echo $page_full_name ?></h1>
    </header>

    <!-- Main Object -->
    <main class="main-content">

      <div class="p-base">
        <h1 class="p-title">Welcome back, Administrator!</h1>
      </div>

      <div class="p-base">
        <!-- about posts for event app -->
        <p>Overview of posts for the event schedule.</p>
        <p></p>

      </div>

      <div class="p-base">
        <p>Your Agenda.</p>

        <div class="post-grid">
          <!-- 1 -->
          <div class="post-grid-items">
            <h1 class="font-bold">ACS Day</h1>
            <p>Agenda on September 27, 2024 1PM, come and participate.</p>
            <a class="underline">Show more...</a>
          </div>
          <!-- 2 -->
          <div class="post-grid-items">
            <h1 class="font-bold">1st General Assembly</h1>
            <p>All College of Sciences will be attend this event!</p>
            <a class="underline">Show more...</a>
          </div>
          <!-- 3 -->
          <div class="post-grid-items">
            <h1 class="font-bold">1st General Assembly</h1>
            <p>All College of Sciences will be attend this event!</p>
            <a class="underline">Show more...</a>
          </div>
        </div>
      </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white p-4 p-footer" id="p-footer">
      <p>All rights reserved <?php echo $proj_current_year ?></p>
    </footer>

    <script src="./../global_assets/js/sidebar.js"></script>
  </div>

</body>

</html>