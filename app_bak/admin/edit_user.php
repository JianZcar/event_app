<?php
session_start();
include "./../../proj_info.php";
include "./../global_components/account.php";

$page_name = "Admin Panel";
$page_full_name = "$page_name | $proj_name";

if (isset($_SESSION['msg_account_announce'])) {
  $msg_account_announce = $_SESSION['msg_account_announce'];
  unset($_SESSION['msg_account_announce']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Checking if username is exist or not
  $username_check = check_username($db_conn,$_GET["id"], $_POST["username"]);

  if (!$username_check) {
    session_aanonuce("Username already exists.", TRUE, "/");
  } else {
    $uname = $_POST["username"];
  }

  if (!empty($_POST["password"])) {
    $password = passwowrd_encoder($_POST["password"]);
  }
  $is_active = isset($_POST["is_active"]) ? 1 : 0;
  $role = $_POST["role"];


  if (!empty($password)) {
    $sql_cmd = <<<SQL
      UPDATE users SET username = '$uname', passwd = '$password', is_active = $is_active, user_role = $role WHERE id = {$_GET["id"]}; 
    SQL;
  } else {
    $sql_cmd = <<<SQL
      UPDATE users SET username = '$uname', is_active = $is_active, user_role = $role WHERE id = {$_GET["id"]};
    SQL;
  }

  if ($db_conn->query($sql_cmd) === TRUE) {
    session_announce("User {$_POST['username']} updated successfully.", TRUE, "user_management.php");
  } else {
    session_announce("Error updating user $username.", TRUE, "user_management.php");
  }

  header("Location: user_management.php");

} else {
  if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $edit_mode = TRUE;

    // Prepare the query
    $sql_cmd = <<<SQL
      SELECT * FROM users WHERE id = $user_id;
    SQL;

    $result = $db_conn->query($sql_cmd);

    // Only one id should be returned
    if ($result->num_rows == 1) {
      $row = $result->fetch_assoc();
      $uname = htmlspecialchars($row['username']);
      $is_active = htmlspecialchars($row['is_active']);
      $role = htmlspecialchars($row['user_role']);
    } else {
      $_SESSION['msg_account_announce'] = "User ID not found.";
      header("Location: user_managment.php");
    }
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
        <a class="btn-menu-list" id="btn-menu-list" onclick="toggleSidebar()"><i class='bx bx-menu'></i></a>
    </div>
    <div>
        <h1 class="text-2xl"><?php echo $page_full_name ?></h1>
    </div>
</header>

<main class="p-4 p-body">
  <?php
    if (isset($msg_account_announce)) {
      echo "<div class='panel-base p-announcement-success'>$msg_account_announce</div>";
    }
  ?>
    <div class="panel-base p-title">
        <h1>Edit User</h1>
    </div>

    <div class="panel-base">
        <form class="p-form-user" method="post">
            <div class="frmInput">
                <input type="text" name="username" id="username" class="tbox-preset-1"
                placeholder="Username" required minlength="3"
                value="<?php echo $uname?>">
            </div>
            <div class="frmInput">
                <input type="password" name="password" id="password" class="tbox-preset-1"
                placeholder="(Unchanged)" minlength="8">
            </div>
            <div class="frmInput">
                Active Account <input type="checkbox" name="is_active"
                id="is_active" value="<?php echo $is_active?>">
            </div>
            <div class="frmInput">
                <select name="role" id="role" required>
                    <option value="1">Admin</option>
                    <option value="2">User</option>
                </select>
            </div>
            <div class="frmInput">
                <button type="submit" class="btn-common btn-accept-1">Save</button>
            </div>
            <div class="frmInput">
                <button type="button" class="btn-common" onclick="window.location.href='./user_management.php';" class="btn-common-1">Cancel</button>
            </div>
            <div class="frmInput">
                <button type="button" class="btn-common btn-danger-1" onclick="window.location.href='delete_user.php?id=<?php $user_id ?>';" class="btn-common-1">Delete</button>
            </div>
        </form>
    </div>
</main>

<footer class="bg-gray-800 text-white p-4 p-footer">
    <p>All rights reserved <?php echo $proj_current_year ?></p>
</footer>
<script src="./../global_assets/js/sidebar.js"></script>
</div>
</body>
</html>