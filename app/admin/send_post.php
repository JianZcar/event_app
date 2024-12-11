<?php
session_start();
include_once "./../global_components/base.php";
web_start();

include_once "./../global_components/account.php";
include_once "./../global_components/pagination.php";
include_once "./../global_components/exec_email.php";
include_once "./../global_components/post_query.php";

// Page Info
$page_name = "Send to";
$page_full_name = page_full_name();

// Check if the id is set
posts_check();

// POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get post data
  $set_email = isset($_POST['set_email']) ? $_POST['set_email'] : NULL;
  $set_user = isset($_POST['set_user']) ? $_POST['set_user'] : NULL;

  // Preparetion the post
  $poster_data = view_post($_GET['id'], $_SESSION['user_id']);
  $subject_name = $poster_data['subject_name'];
  $content = $poster_data['content'];

  // If only to access the email to send but not for users
  if (isset($set_email) && !isset($set_user)) {
    $email = $set_email;
  } else {
    // if user is set from the user list
    $post_id = $_GET['id'];
    $user_id = $set_user;
    $email = get_user_email($user_id);
  }

  // Send email
  mail_sender($post_id, "Test32", $email, "TestReceiver", $subject_name, $content, NULL);

}
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
      user_roles.bg_color,
      user_infos.email
  FROM 
      users 
  INNER JOIN user_roles ON users.user_role = user_roles.id
  INNER JOIN user_infos ON users.id = user_infos.id
  ORDER BY users.id;
  SQL;
// echo $sql_users;

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

// Pagination
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

      <div class="p-base">
        <h1 class="p-title">Select user or enter email manually and send the invitation.</h1>
      </div>
      <div class="p-base ">
        <form method="post" class="flex flex-col w-full">
        <h1>Email Address (Manually)</h1>
        <div class="flex flex-row">
          <input class="p-textbox" placeholder="Enter the email address">
          <button class="btn-search-1">Send</button>
        </div>
        </form>
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
                <td class="py-1 border text-center p-4">Email</td>
                <td class="py-1 border text-center p-4k">Actions</td>
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
                  $email = $row['email'];

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
                      <?php echo $email; ?>
                    </span>
                  </td>
                  <td class="py-5 border text-center font-bold p-4">
                    <form method="post">
                      <button type="submit" name="set_user" value="<?php echo $user_id; ?>" class="btn-common h-full w-full block md:h-1/2 md:w-1/2" style="margin: 0 auto;">Invite</button>
                    </form>
                    
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
        <!-- paginate_init -->
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