<?php
session_start();
include_once "./../../proj_info.php";
include_once "./../global_components/pagination.php";

$page_name = "Posts";
$page_full_name = "$page_name | $proj_name";

// Post info





// Message Control
if (isset($_SESSION['msg_account_announce'])) {
  $msg_account_announce = $_SESSION['msg_account_announce'];
  // unset($_SESSION['msg_account_announce']);
}

$sql_users = <<<SQL
  SELECT 
    subject_name,
    id,
    content,
    start_datetime,
    end_datetime
  FROM
    event_posts
  SQL;

// Access paginate 
$limit = 5;

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
  // if theres greather than last page it will redirect to the last page
  // if ($_GET['page'] > $records[1]) {
  //   header("Location: posts.php?page=" . $records[1]);
  // } else if ($_GET['page'] < 1) {
  //   header("Location: posts.php?page=1");
  // } else {
    
  // }
  $records = paginate($db_conn, $sql_users, $_GET['page'], $limit);
} 
else {
  $records = paginate($db_conn, $sql_users, 0, $limit);
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

  <!-- Left Sidebar -->
  <div class="slide-panel" id="sidebar-content">
    <?php include_once './../global_components/sidebar.php'; ?>
  </div>

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

      <!-- output the msg control -->
      <?php if (isset($msg_account_announce)) : ?>
        <div class="p-base">
          <p><?php echo $msg_account_announce ?></p>
        </div>
      <?php endif; ?>

      <div class="p-base">
        <!-- about posts for event app -->
        <p>Overview of posts for the event schedule.</p>
        <p></p>

      </div>

      <div class="p-base">
        <p>Your Agenda.</p>

        <div class="post-grid">

          <?php if ($records['records']->num_rows > 0) : ?>
          <?php while ($row = $records['records']->fetch_assoc()) : ?>
          <div class="post-grid-items">
            <h1 class="font-bold"><?php echo $row['subject_name'] ?></h1>
            <!-- start date -->
            <!-- <p><?php 
            
            // get the datetime as variable today
            $today_datetime = date("Y-m-d H:i:s");

            // matching with start_datetime and end_datetime are equal and use time only
            if ($row['start_datetime'] == $row['end_datetime']) {
              echo date("h:i A", strtotime($row['start_datetime']));
            }
            
            echo $row['start_datetime'] ?></p> -->

            <p class="text-justify">
              <?php
              $content = $row['content'];
              if (strlen($content) > 70) {
                $content = substr($content, 0, 65) . '...';
              }
              echo $content;
              ?>
            </p>
            <a class="underline" href="./view_posts.php?id=<?php echo $row['id'];?>">Show more...</a>
          </div>
          <?php endwhile; ?>
          <?php else : ?>
            <h1>No posts available.</h1>
          <?php endif; ?> 
        </div>

        <div class="flex flex-row text-center items-center justify-center">
          <?php paginate_init($records); ?>
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