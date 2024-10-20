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
      user_roles.role_name 
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
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
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
        echo "<div class='panel-base p-announcement-success'>$msg_account_announce</div>";
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
      <div class="p-search">
        <input type="text" name="search" id="search" placeholder="Search">
        <button type="submit">Search</button>
      </div>
      <table class="p-table">
        <thead>
          <tr>
            <th>Username</th>
            <th>Active</th>
            <th>Role</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
            // print all users
            if ($result_users->num_rows > 0) {
              while ($row = $result_users->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . ($row['is_active'] == 1 ? 'Yes' : 'No') . "</td>";
                echo "<td>" . $row['role_name'] . "</td>";
                echo "<td>";
                echo "<button onclick=\"window.location.href='edit_user.php?id=" . $row['id'] . "';\">Edit</button>";
                echo "<button onclick=\"window.location.href='delete_user.php?id=" . $row['id'] . "';\">Delete</button>";
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