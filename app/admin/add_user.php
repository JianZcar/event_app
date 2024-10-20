<?php
  session_start();
  include "./../../proj_info.php";

  $page_name = "Admin Panel";
  $page_full_name = "$page_name | $proj_name";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $is_active = isset($_POST["is_active"]) ? 1 : 0;
    $role = $_POST["role"];

    $sql_cmd = <<<SQL
    INSERT INTO 
      users(username, passwd, is_active, user_role)
    VALUES
      ('$username', '$password', $is_active, $role);
    SQL;

    if ($db_conn->query($sql_cmd) === TRUE) {
      $_SESSION['msg_account_announce'] = "Account $username created successfully.";
    } else {
      $_SESSION['msg_account_announce'] = "Error: " . $sql_cmd . "<br>" . $db_conn->error;
    }

    header("Location: index.php");
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
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body class="mainstream-panel">
<div class="sidebar-content" id="sidebar-content">
  123abc
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
      <h1>Add User</h1>
    </div>

    <div>
      <?php
        if (isset($msg_account_announce)) {
          echo "<div class='panel-base p-announcement-success'>$msg_account_announce</div>";
        }
      ?>
    </div>
    <div class="panel-base">
      <form class="p-form-user" method="post">
        <div class="frmInput">
          <!-- <label for="username">Username</label> -->
          <input type="text" name="username" id="username" class="tbox-preset-1" placeholder="Username" required minlength="3">
        </div>
        <div class="frmInput">
          <!-- <label for="password">Password</label> -->
          <input type="password" name="password" id="password" class="tbox-preset-1" placeholder="Password" required minlength="8">
        </div>
        <div class="frmInput">
        Active Account <input type="checkbox" name="is_active" id="is_active" value="1">
        </div>
        <div class="frmInput">
          <select name="role" id="role">
            <option value="1">Admin</option>
            <option value="2">User</option>
          </select>
        </div>
        <div class="frmInput">
          <button type="submit" href="" class="btn-accept-1">Add User</button>
        </div>
        <div class="frmInput">
          <button type="submit" onclick="window.location.href='index.php';" class="btn-common-1">Cancel</button>
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