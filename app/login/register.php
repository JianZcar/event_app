<?php
session_start();
include_once "./../global_components/base.php";
web_start();

// Custom components
include_once "./components/module.php";
include_once "./../global_components/account.php";
include_once "./../login/components/exec_auth.php";

// Page Info
$page_name = "Register";
$page_full_name = page_full_name();

// Message Control
if (isset($_SESSION['msg_account_announce'])) {
  $msg_account_announce = $_SESSION['msg_account_announce'];
  unset($_SESSION['msg_account_announce']);
}

// Register execute
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password1"];
  $password_confirm = $_POST["password2"];
  $email = $_POST["email"];
  
  if ($password == $password_confirm) {
   register_auth($username, $password, $email);
//       session_announce("Account created successfully", true, "index.php");
//       $_SESSION['msg_account_announce'] = "Account created successfully";
//   else {
//       session_announce("Account creation failed", true, "register.php");
//       $_SESSION['msg_account_announce'] = "Account creation failed";
//    }
//  } else {
//     session_announce("Password does not match", true, "register.php");
//     $_SESSION['msg_account_announce'] = "Password does not match";
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
  <div class="main-content">
    <?php login_navbar(); ?>
    <?php
      if (isset($msg_account_announce)) {
        $message = $msg_account_announce;
        system_message($message);
        unset($msg_account_announce);
      }?>
    <main class="flex flex-col w-full h-full m-h-screen">
      <?php form_register(); ?>
    </main>

    <?php global_footer(); ?>
    <?php global_last_js(); ?>
  </div>
</body>
</html>