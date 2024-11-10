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

// Message Control
if (isset($_SESSION['msg_account_announce'])) {
  $msg_account_announce = $_SESSION['msg_account_announce'];
  unset($_SESSION['msg_account_announce']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];

  if (login_auth($username, $password)) {
    header("Location: ./../admin/index.php");
  } else {
    session_announce("Invalid Username or Password", true, "index.php");
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

<body class="flex flex-row min-w-screen">
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

    <?php global_footer($proj_name, $proj_version, $proj_author, $proj_current_year); ?>
    <?php global_last_js(); ?>
  </div>

</body>

</html>