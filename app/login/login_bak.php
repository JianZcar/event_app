<?php
session_start();
include_once "./../../proj_info.php";

$page_name = "Login";
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
    <div class="main-content">
        <!-- Header -->
        <header class="flex flex-row bg-blue-500 text-white p-1 btn-slide">
            <a class="p-2 text-2xl hover-action" id="btn-menu-list" onclick="slideOpen()"><i class='bx bx-menu'></i></a>
            <h1 class="p-2 text-2xl"><?php echo $page_full_name ?></h1>
        </header>

        <!-- Main Object -->
        <main class="flex flex-col w-full h-full m-h-screen">

            <div class="p-base">
                <h1 class="p-title">Welcome back, Administrator!</h1>
            </div>

            <div class="p-base">
                <div class="flex flex-col w-full md:w-1/2 xl:w-2/5 2xl:w-2/5 3xl:w-1/3 mx-auto p-8 md:p-10 2xl:p-12 3xl:p-14 bg-[#ffffff] rounded-2xl shadow-xl">
                    <form class="flex flex-col" method="post">
                        <div class="pb-6">
                            <label for="username" class="block mb-2 text-sm font-medium text-[#111827]">Username</label>
                            <div class="relative text-gray-400">
                                <input type="text" name="username" id="username" class="p-textbox" placeholder="Username" autocomplete="off" value="">
                            </div>
                        </div>

                        <div class="pb-6">
                            <label for="password" class="block mb-2 text-sm font-medium text-[#111827]">Password</label>
                            <div class="relative text-gray-400">
                                <input type="password" name="password" id="password" class="p-textbox" autocomplete="new-password" placeholder="Password">
                            </div>
                        </div>

                        <div class="pb-6 flex flex-row justify-between">
                            <label for="is_active" class="block mb-2 text-sm font-medium text-[#111827]">Active</label>
                            <div class="relative text-gray-400">
                                <input type="checkbox" name="is_active" id="is_active" class="checkbox-1">
                            </div>
                        </div>

                        <div class="pb-6">
                            <label for="role" class="block mb-2 text-sm font-medium text-gray-900">Role Type</label>
                            <select name="role" id="role" class="selection-drop-1">
                                <option selected disabled>Choose a role</option>
                                <option value="1">Admin</option>
                                <option value="2">User</option>
                            </select>
                        </div>
                        <button type="submit" class="btn-post-accept-1">Add User</button>
                        <a type="submit" class="btn-post-danger-1" href="./user_management.php">Cancel</a>
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