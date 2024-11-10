<?php
session_start();
include_once "./../global_components/base.php";
web_start();

// Custom componets
include "./../global_components/exec_posts.php";
include "./../global_components/pagination.php";

// Page Info
$page_name = "Posts";
$page_full_name = page_full_name();

// Post info


// Message Control
if (isset($_SESSION['msg_account_announce'])) {
  $msg_account_announce = $_SESSION['msg_account_announce'];
  // unset($_SESSION['msg_account_announce']);
}

$sql_ = <<<SQL
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
$limit = 12;

$records = get_posts($limit);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php global_style(); ?>
  <title><?php echo $page_full_name ?></title>
  <?php global_first_js();?>
</head>

<body class="flex flex-row min-w-screen">

  <!-- Left Sidebar -->
  <div class="slide-panel" id="sidebar-content">
    <?php sidebar_init(); ?>
  </div>

  <!-- Rest is main content -->
  <!-- Main Content -->
  <div class="flex flex-col w-screen max-w-screen min-h-screen">
    <!-- Header -->
    <?php global_header($page_full_name, $proj_name); ?>

    <!-- Main Object -->
    <main class="main-content">

      <!-- output the msg control -->
      <?php if (isset($msg_account_announce)) : ?>
        <div class="p-base">
          <p><?php echo $msg_account_announce ?></p>
        </div>
      <?php endif; ?>

      <?php system_message("Overview of posts for the event schedule."); ?>

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

    <?php global_footer($proj_name, $proj_version, $proj_author, $proj_current_year); ?>
    <?php global_last_js(); ?>
  </div>

</body>

</html>