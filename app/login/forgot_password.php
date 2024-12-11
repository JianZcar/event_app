<?php
session_start();
include_once "./../../proj_info.php";

$page_name = "Forgot Password";
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
if (isset($db_conn)) {
  $result_users = $db_conn->query($sql_users);
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
  <!-- <link href="./../global_assets/css/panel.css" rel="stylesheet"> -->
  <!-- <link href="./../global_assets/css/sidebar.css" rel="stylesheet"> -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body class="b-body">

  <!-- Rest is main content -->
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
        <div class="flex flex-col w-full md:w-1/2 xl:w-2/5 2xl:w-2/5 3xl:w-1/3 mx-auto p-8 md:p-10 2xl:p-12 3xl:p-14 bg-[#ffffff] rounded-2xl shadow-xl">
          <form class="flex flex-col" method="post">
            <div class="pb-6">
              <label for="username" class="block mb-2 text-sm font-medium text-[#111827]">Username</label>
              <div class="relative text-gray-400">
                <input type="text" name="username" id="username" class="p-textbox" placeholder="Username" autocomplete="off" value="">
              </div>
            </div>

            <button type="submit" class="btn-post-accept-1">Send Password</button>
            <p class="text-gray-800 text-sm !mt-8 text-center">Want back to login? <a href="./index.php" class="text-blue-600 hover:underline ml-1 whitespace-nowrap font-semibold">Login here</a></p>
          </form>
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