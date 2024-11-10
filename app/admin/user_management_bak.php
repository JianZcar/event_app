<?php
session_start();
include "./../../proj_info.php";
include "./../global_components/pagination.php";
$page_name = "User Management";
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
  INNER JOIN user_roles ON users.user_role = user_roles.id
  ORDER BY users.id;
  SQL;
// echo $sql_users;

$limit = 10;

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
  // if theres greather than last page it will redirect to the last page
  if ($_GET['page'] > $records[1]) {
    header("Location: user_management.php?page=" . $records[1]);
  } else if ($_GET['page'] < 1) {
    header("Location: user_management.php?page=1");
  } else {
    $records = paginate($db_conn, $sql_users, $_GET['page'], $limit);
  }
} else {
  $records = paginate($db_conn, $sql_users, 0, $limit);
}
// Old
// $result_users = $db_conn->query($sql_users);
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
  <div class="main-content">
    <!-- Header -->
    <header class="navigator-header">
      <a class="p-2 text-2xl hover-action" id="btn-menu-list" onclick="slideOpen()"><i class='bx bx-menu'></i></a>
      <h1 class="p-2 text-2xl"><?php echo $page_full_name ?></h1>
    </header>

    <!-- Main Object -->
    <main class="flex flex-col w-full h-full m-h-screen">

      <?php

      if (isset($msg_account_announce)) {
        echo <<<HTML
        <div class="p-base">
          <p>$msg_account_announce</p>
        </div>
        HTML;
      }
      ?>

      <div class="p-base">
        <h1 class="p-title">Welcome back, Administrator!</h1>
      </div>

      <div class="p-base flex flex-row justify-between items-center">
        <p>Here's a list of users.</p>
        <button class="btn-accept-1" onclick="window.location.href='./add_user.php'">Add</button>
      </div>

      <div class="p-base">
        <div class="flex flex-row pb-2 space-x-4">
          <input class="p-textbox" placeholder="Type your name..">
          <button class="btn-search-1">Search</button>
        </div>

        <!-- User's Table -->
        <div class="relative overflow-hidden shadow-md rounded-lg" bis_skin_checked="1">
          <table class="table-fixed w-full text-left">
            <thead class="uppercase bg-blue-500 text-[#e5e7eb]">
              <tr>
                <td class="py-1 border text-center p-4">Users</td>
                <td class="py-1 border text-center p-4 hidden md:table">STATUS</td>
                <td class="py-1 border text-center p-4k">ACTIONS</td>
              </tr>
            </thead>
            <tbody class="bg-white text-gray-500">
              <?php if ($records[0]->num_rows > 0) : ?>
              <?php while ($row = $records[0]->fetch_assoc()) : ?>
                <?php
                  $user_id = $row['id'];
                  $username = $row['username'];
                  $role_name = $row['role_name'];
                  $color = $row['color'];
                  $bg_color = $row['bg_color'];
                  $is_active = $row['is_active'];
                ?>
                <tr class="py-5">
                  <td class="flex flex-row items-center py-5 border text-center font-bold p-4">
                    <img class="w-16 h-16 rounded-full mr-5 border-2 border-black" src="./../global_assets/img/default_user.png" alt="<?php echo $username; ?>">
                    <span><?php echo $username; ?></span>
                  </td>
                  <td class="py-5 border text-center font-bold p-4 hidden md:table">
                    <span class="<?php echo $status_color; ?>">
                      <i class='bx <?php echo $status_icon; ?>'></i>
                      <span><?php echo $status; ?></span>
                    </span>
                  </td>
                  <td class="py-5 border text-center font-bold p-4">
                    <a href="./edit_user.php?id=<?php echo $user_id; ?>" class="btn-common h-full w-full block md:h-1/2 md:w-1/2 " style="margin: 0 auto;">Edit</a>
                  </td>
                  </td>
                </tr>
              <?php endwhile; ?>
              <?php else : ?>
                <tr>
                  <td class="py-5 border text-center font-bold p-4">No users available.</td>
                </tr>
              <?php endif; ?>
              <!-- <?php
              if ($result_users->num_rows > 0) {
                while ($row = $result_users->fetch_assoc()) {
                  $user_id = $row['id'];
                  $username = $row['username'];
                  $role_name = $row['role_name'];
                  $color = $row['color'];
                  $bg_color = $row['bg_color'];
                  $is_active = $row['is_active'];

                  $status = $is_active == 1 ? "Active" : "Inactive";
                  $status_color = $is_active == 1 ? "text-green-500" : "text-red-500";
                  $status_icon = $is_active == 1 ? "bx-check" : "bx-x";

                  echo <<<HTML
                        <tr class="py-5">
                          <td class="flex flex-row items-center py-5 border text-center font-bold p-4">
                            <img class="w-16 h-16 rounded-full mr-5 border-2 border-black" src="./../global_assets/img/default_user.png" alt=""$username>
                            <span>$username</span>
                          </td>
                          <td class="py-5 border text-center font-bold p-4 hidden md:table">
                            <span class="$status_color">
                              <i class='bx $status_icon'></i>
                              <span>$status</span>
                            </span>
                          </td>
                          <td class="py-5 border text-center font-bold p-4">
                              <a href="./edit_user.php?id=<?php echo $user_id; ?>" class="btn-common h-full w-full block md:h-1/2 md:w-1/2 " style="margin: 0 auto;">Edit</a>
                          </td>
                        </tr>
                        HTML;
                }
              }
              ?> -->
            </tbody>
          </table>
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