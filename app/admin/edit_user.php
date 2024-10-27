<?php
session_start();
include "./../../proj_info.php";
include "./../global_components/account.php";

$page_name = "Edit User";
$page_full_name = "$page_name | $proj_name";

if (isset($_SESSION['msg_account_announce'])) {
  $msg_account_announce = $_SESSION['msg_account_announce'];
  unset($_SESSION['msg_account_announce']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Checking if username exists or not
  $username_check = check_username($db_conn, $_GET["id"], $_POST["username"]);

  if (!$username_check) {
    session_announce("Username already exists.", TRUE, "/");
  } else {
    $uname = $_POST["username"];
  }

  if (!empty($_POST["password"])) {
    $password = password_encoder($_POST["password"]);
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
      header("Location: user_management.php");
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $page_full_name ?></title>
  <link href="../global_assets/css/output.css" rel="stylesheet">
  <link href="./../global_assets/css/global_footer.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <link href="./../global_assets/css/boxicons.min.css" rel='stylesheet'>
</head>

<body class="flex flex-row min-w-screen">

  <!-- Left Sidebar -->
  <div class="slide-panel" id="sidebar-content">
    <?php include './../global_components/sidebar.php'; ?>
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
      <div class="p-base">
        <h1 class="p-title">Welcome back, Administrator!</h1>
      </div>

      <div class="p-base">
        <p>What would you like to do today?</p>
      </div>

      <div class="p-base">
        <div class="flex flex-col w-full md:w-1/2 xl:w-2/5 2xl:w-2/5 3xl:w-1/3 mx-auto p-8 md:p-10 2xl:p-12 3xl:p-14 bg-[#ffffff] rounded-2xl shadow-xl">
          <form class="flex flex-col" method="post">
            <div class="pb-6">
              <label for="username" class="block mb-2 text-sm font-medium text-[#111827]">Username</label>
              <div class="relative text-gray-400">
                <input type="text" name="username" id="username" class="p-textbox" placeholder="Username" autocomplete="off" value="<?php echo $uname ?>">
              </div>
            </div>
            <div class="pb-6">
              <label for="password" class="block mb-2 text-sm font-medium text-[#111827]">Password</label>
              <div class="relative text-gray-400">
                <input type="password" name="password" id="password" placeholder="(Unchanged)" class="p-textbox" autocomplete="new-password" placeholder="(Unchanged)">
              </div>
            </div>

            <div class="pb-6 flex flex-row justify-between">
              <label for="is_active" class="block mb-2 text-sm font-medium text-[#111827]">Active</label>
              <div class="relative text-gray-400">
                <input type="checkbox" name="is_active" id="is_active" class="checkbox-1" <?php echo $is_active ? 'checked' : ''; ?>>
                <!-- <span class="text-sm">Is Active</span> -->
              </div>
            </div>

            <div class="pb-6">
              <label for="role" class="block mb-2 text-sm font-medium text-gray-900">Role Type</label>
              <select name="role" id="role" class="selection-drop-1" required>
                <option value="1">Admin</option>
                <option value="2">User</option>
              </select>
            </div>

            <button type="submit" class="btn-post-accept-1">Update User</button>
            <a href="./user_management.php" class="btn-post-common-1">Cancel</a>
            <button class="btn-post-danger-1">Delete</button>
            <a href="./delete_user.php?id=<?php echo $user_id ?>" class="btn-post-danger-1">Delete</a>
          </form>
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