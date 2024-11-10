<?php
session_start();
include "./../../proj_info.php";
include "./../global_components/account.php";
// Get information post
if (!isset($_GET['id'])) {
  header ("Location: ./posts.php");
} else if (is_numeric($_GET['id'])) {
  $post_id = $_GET['id'];

  // Prepare the query
  $sql_cmd = <<<SQL
    SELECT 
      subject_name,
      id,
      content,
      start_datetime,
      end_datetime
    FROM
      event_posts
    WHERE
      id = $post_id;
    SQL;

  // Execute the query
  $result = $db_conn->query($sql_cmd);
  if ($result->num_rows == 0) {
    header("Location: ./posts.php");
    session_announce("Post not found.", TRUE, "./posts.php");
  } else {
    $row = $result->fetch_assoc();
    $subject_name = $row['subject_name'];
    $content = $row['content'];
    $start_datetime = $row['start_datetime'];
    $end_datetime = $row['end_datetime'];
  }
} else {
  // This is incase when the post is not found
  session_announce("Post ID not provided.", TRUE, "./posts.php");
}
$page_name = "Admin Panel";
$page_full_name = "$page_name | $proj_name";

// Message Control
if (isset($_SESSION['msg_account_announce'])) {
  $msg_account_announce = $_SESSION['msg_account_announce'];
  unset($_SESSION['msg_account_announce']);
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

  <?php // Tinymce Section ?>
  <!-- <script src="./../global_components/tinymce/js/tinymce/tinymce.min.js"></script>
  <script>
    tinymce.init({
      selector: 'textarea',
      menubar: false,
      plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
      toolbar_mode: 'floating',
      toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help'
    });
  </script> -->
</head>

<body class="b-body">

  <!-- Left Sidebar -->
  <div class="slide-panel" id="sidebar-content">
    <?php include './../global_components/sidebar.php'; ?>
  </div>

  <!-- Rest is main content -->
  <!-- Main Content -->
  <div class="main-content">
    <!-- Header -->
    <header class="navigator-header btn-slide">
      <a class="p-2 text-2xl hover-action" id="btn-menu-list" onclick="slideOpen()"><i class='bx bx-menu'></i></a>
      <h1 class="p-2 text-2xl"><?php echo $page_full_name ?></h1>
    </header>

    <!-- Main Object -->
    <main class="flex flex-col w-full h-full m-h-screen">

      <!-- <div class="p-base">
        <a href="" class="btn-post-back"><i class='bx bx-arrow-back w-4'></i></a>
      </div> -->

      <div class="p-base">
        <!-- tailwind title design -->
        <h1 class="font-bold">Subject: <?php echo $subject_name ?></h1>

        <!-- tailwind content design -->
        <div class="p-2">
          
          <!-- <p>Start Date: <?php echo $start_datetime ?></p>
          <p>End Date: <?php echo $end_datetime ?></p> -->

          <p><?php echo $content?></p>
          <!-- content -->

        <!-- <textarea id="default-editor">
          <p><em>Hello</em>, <span style="text-decoration: underline;"><strong>World!</strong></span></p>
        </textarea> -->


        <div>
          
        </div>
      </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white p-4 p-footer" id="p-footer">
      <p>All rights reserved <?php echo $proj_current_year ?></p>
    </footer>
  </div>

</body>

</html>