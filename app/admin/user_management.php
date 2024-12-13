<?php
session_start();
include_once "./../global_components/base.php";
web_start();

// Custom componets
include_once("./components/module.php");
include_once("./../global_components/account.php");

// Page Info
include_once "./../global_components/pagination.php";
$page_name = "User Management";
$page_full_name = page_full_name();

// Message Control
if (isset($_SESSION['msg_account_announce'])) {
  $msg_account_announce = $_SESSION['msg_account_announce'];
  unset($_SESSION['msg_account_announce']);
}

$sql_users = user_lists(true);

$limit = 10;

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
  // if theres greather than last page it will redirect to the last page
  // if ($_GET['page'] > $records[1]) {
  //   header("Location: user_management.php?page=" . $records[1]);
  // } else if ($_GET['page'] < 1) {
  //   header("Location: user_management.php?page=1");
  // } else {
  //   $records = paginate($db_conn, $sql_users, $_GET['page'], $limit);
  // }
  $records = paginate($db_conn, $sql_users, $_GET['page'], $limit);
} else {
  $records = paginate($db_conn, $sql_users, 0, $limit);
}
// Old
// $result_users = $db_conn->query($sql_users);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php global_style(); ?>
  <title><?php echo $page_full_name ?></title>
  <?php global_first_js();?>
</head>

<body class="b-body">
  <div class="slide-panel" id="sidebar-content">
    <?php sidebar_init(); ?>
  </div>
  <div class="main-content">
    <?php global_header($page_full_name, $proj_name); ?>

    <main class="flex flex-col w-full h-full m-h-screen">
      <?php 
      if (isset($msg_account_announce)) {
        msg_account_announce($msg_account_announce);
        unset($msg_account_announce);
      }
      ?>
      <?php system_message('Heres the users list.'); ?>
      <?php dialog_user_add(); ?>
      <div class="p-base">
        <?php search_bar(); ?>
        <div class="relative overflow-hidden shadow-md rounded-lg" bis_skin_checked="1">
          <table class="table-fixed w-full text-left">
            <thead class="uppercase bg-blue-500 text-[#e5e7eb]">
              <tr>
                <td class="py-1 border text-center p-4">Users</td>
                <td class="py-1 border text-center p-4">STATUS</td>
                <td class="py-1 border text-center p-4k">ACTIONS</td>
              </tr>
            </thead>
            <tbody class="bg-white text-gray-500">
              <?php if ($records['records']->num_rows > 0) : ?>
              <?php while ($row = $records['records']->fetch_assoc()) : ?>
                <?php
                  $user_id = $row['id'];
                  $username = $row['username'];
                  $role_name = $row['role_name'];
                  $color = $row['color'];
                  $bg_color = $row['bg_color'];
                  $is_active = $row['is_active'];

                  $status = $is_active == 1 ? "Active" : "Inactive";
                  $status_color = $is_active == 1 ? "text-green-500" : "text-red-500";
                  $status_icon = $is_active == 1 ? "bx-check" : "bx-x";

                ?>
                <tr class="py-5">
                  <td class="flex flex-row items-center py-5 border text-center font-bold p-4">
                    <img class="w-16 h-16 rounded-full mr-5 border-2 border-black" src="./../global_assets/img/default_user.png" alt="<?php echo $username; ?>">
                    <span><?php echo $username; ?></span>
                  </td>
                  <td class="py-5 border text-center font-bold p-4">
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
            </tbody>
          </table>
        </div>

        <div class="flex flex-row text-center items-center justify-center">
          <?php paginate_init($records); ?>
        </div>
      </div>
    </main>

    <?php global_footer(); ?>
    <?php global_last_js(); ?>
  </div>
</body>
</html>