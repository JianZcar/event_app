<?php
session_start();
include_once "./../global_components/base.php";
web_start();

// Custom components
include_once "./components/module.php";
// include_once "./components/exec_auth.php";
include_once "./../global_components/account.php";
include_once "./components/exec_auth.php";
// Page Info
$page_name = "Login";
$page_full_name = page_full_name();

// Check if the user is logged in then direct to admin page
if (isset($_SESSION['user_id'])) {
  header("Location: ./../admin/");
  exit();
}
// Message Control
if (isset($_SESSION['msg_account_announce'])) {
  $msg_account_announce = $_SESSION['msg_account_announce'];
  unset($_SESSION['msg_account_announce']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];

  if (login_auth($username, $password) == true) {
    // header("Location: ./../admin/index.php");
    // exit();
  } else {
    // $_SESSION['msg_account_announce'] = "Invalid Username or Password";
    // header("Location: index.php");
    // exit();
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php global_style(); ?>
  <title><?php echo $page_full_name ?></title>
  <?php global_first_js(); ?>
</head>

<body class="b-body">
  <div class="w-full m-w-full">
    <?php login_navbar(); ?>

    <main class="main-content">
      <?php
      if (isset($msg_account_announce)) {
        $message = $msg_account_announce;
        system_message($message);
        unset($msg_account_announce);
      }?>
      <!-- <?php system_message(); ?> -->
      <?php form_login(); ?>
    </main>

    <?php global_footer(); ?>
    <?php global_last_js(); ?>
  </div>

</body>

</html>