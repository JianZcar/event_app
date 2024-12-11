<?php
session_start();
include_once "./../global_components/base.php";
web_start();

// Custom componets

// Page Info
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
    header("Location: user_managment.php");
  } else {
    $_SESSION['msg_account_announce'] = "User ID not provided.";
    header("Location: user_managment.php");
  }
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
      $username = $row['username'];
      $is_active = $row['is_active'];
      $role = $row['user_role'];
    } else {
      $_SESSION['msg_account_announce'] = "User ID not found.";
      header("Location: user_management.php");
    }
  } else {
    $_SESSION['msg_account_announce'] = "User ID not provided.";
    header("Location: user_management.php");
  }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <?php global_style(); ?>
  <title><?php echo $page_full_name ?></title>
  <?php global_first_js(); ?>
  <?php tinymce_js_init(); ?>
</head>
<body class="b-body h-screen">
  <div class="slide-panel" id="sidebar-content">
    <?php sidebar_init(); ?>
  </div>



  <div class="flex flex-col w-screen max-w-screen min-h-screen">
    <header class="navigator-header btn-slide">
      <a class="p-2 text-2xl hover-action" id="btn-menu-list" onclick="slideOpen()"><i class='bx bx-menu'></i></a>
      <h1 class="p-2 text-2xl"><?php echo $page_full_name?></h1>
    </header>
    <main class="flex flex-col w-full h-full m-h-screen">

        <div class="p-base">
          <p>Do you want to delete <?php echo $username?>?</p>

          <form action="delete_user.php?id=<?php echo $user_id?>" method="post" class="flex flex-col space-y-4">
            <button type="submit" class="btn-post-danger-1  ">Delete</button>
            <a href="user_management.php" class="btn-post-common-1">Cancel</a>
          </form>
        </div>

    </main>
    <?php global_footer(); ?>
    <?php global_last_js(); ?>
  </div>

</body>
</html>