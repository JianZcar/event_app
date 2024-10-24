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
      <h1>Admin Panel</h1> 
    </div>

    <?php
      if (isset($msg_account_announce)) {
        echo "<div class=\"panel-base p-accept\">$msg_account_announce</div>";
      }
    ?>

    <div class="panel-base p-poster">
      <form>
        User Management Properties
        <table>
          <tr>
            <td><label for="enable-user-registration">Enable User Registration</label></td>
            <td><input type="checkbox" id="enable-user-registration" name="user-registration" value="enable"></td>
          </tr>
        </table>
      </form>
    </div>

    <div class="panel-base">
      <h3>Manage Users</h3>
      <!-- add button <A> -->
      <!-- <a href="" class="btn-add">Add</a> -->
      <button class="btn-common btn-accept-1" onclick="window.location.href='add_user.php';">Add User</button>
      <div class="p-search">
        <input type="text" name="search" id="search" placeholder="Search">
        <button type="submit">Search</button>
      </div>
      <table class="p-table">
          <thead>
              <tr>
                  <th colspan="3">Username</th>
                  <th>Actions</th>
              </tr>
          </thead>
          <tbody>
              <?php
              // print all users
              if ($result_users->num_rows > 0) {
                  while ($row = $result_users->fetch_assoc()) {
                      $user_id = $row['id'];
                      $username = $row['username'];
                      $is_active = ($row['is_active'] == 1 ? "active" : "inactive");
                      $role_name = $row['role_name'];
                      $text_color = $row['color'];
                      $bg_color = $row['bg_color'];
                      echo "<tr>";
                      echo "<td>";
                      echo "<img class=\"table-image\" src=\"../global_assets/img/default_user.png\">";
                      echo "<div class=\"user-info\">";
                      echo "<p class=\"bold\" style=\"color:$text_color;\">$username</p>";
                      echo "<p class=\"role-type\" style=\"background-color: $bg_color\">$role_name</p>";
                      echo "</div>";
                      echo "</td>";
                      echo "<td>";
                      echo "<button onclick=\"window.location.href='edit_user.php?id=$user_id';\" class=\"btn-$is_active\">Edit</button>";
                      echo "</td>";
                      echo "</tr>";
                  }
              } else {
                  echo "<tr><td colspan='4'>No users found.</td></tr>";
              }
              ?>
          </tbody>
      </table>
    </div>
  </main>
  <footer class="bg-gray-800 text-white p-4 p-footer" id="p-footer">
    <p>All rights reserved <?php echo $proj_current_year?></p>
  </footer>
  <script src="./../global_assets/js/sidebar.js"></script>
</div>
</body>
</html>