<?php
session_start();
include "./../../proj_info.php";
$page_name = "Admin Panel";
$page_full_name = "$page_name | $proj_name";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Prepare the delete query
    $sql_cmd = $db_conn->prepare("DELETE FROM users WHERE id = ?");
    $sql_cmd->bind_param("i", $user_id);

    if ($sql_cmd->execute()) {
      $_SESSION['msg_account_announce'] = "User deleted successfully.";
    } else {
      $_SESSION['msg_account_announce'] = "Error deleting user.";
    }

    // Redirect to a confirmation or list page
    header("Location: index.php");
  } else {
    $_SESSION['msg_account_announce'] = "User ID not provided.";
    header("Location: index.php");
  }
}
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
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body class="mainstream-panel">
<div class="bg-blue-500  sidebar-content" id="sidebar-content">
  <?php include_once './../global_assets/php/sidebar.php';?>
</div>

<div class="main-content">
<header class="bg-blue-500 text-white p-4 p-base-nav">
  <div>
    <!-- call the function toggleSidebar() -->
    <a class="btn-menu-list" id="btn-menu-list" onclick="toggleSidebar()"><i class='bx bx-menu'></i></a>
    <!-- <a class="btn-menu-list" id="btn-menu-list"><i class='bx bx-list-ul'>Menu</i></a> -->
  </div>
  <div>
    <h1 class="text-2xl"><?php echo $page_full_name?></h1>
  </div>
</header>

<main class="p-4 p-body">
  <!-- <p>Main content goes here.</p> -->
  <div class="panel-base p-title">
    <h1>Delete User</h1>
  </div>

  <div class="panel-base">
    <form class="p-form-user" method="post">
      <div class="frmInput">
        Are you sure you want to delete this user?
      </div>
      <div class="frmInput">
        <button type="submit" class="btn-common btn-danger-1">Delete</button>
      </div>
      <div class="frmInput">
        <button type="button" class="btn-common" onclick="window.location.href='index.php';" class="btn-common-1">Cancel</button>
      </div>
      <!-- <button type="submit" class="btn-post-1">Add User</button> -->
    </form>
  </div>
</main>
<footer class="bg-gray-800 text-white p-4 p-footer">
  <p>All rights reserved <?php echo $proj_current_year?></p>
</footer>
<script src="./../global_assets/js/sidebar.js"></script>
</div>
</body>
</html>