<?php
  session_start();
  include "./../../proj_info.php";

  $page_name = "Calendar";
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
  $result_users = $db_conn->query($sql_users);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $page_full_name?></title>

  <!-- <link href="./../global_assets/css/panel.css" rel="stylesheet"> -->
  <!-- <link href="./../global_assets/css/sidebar.css" rel="stylesheet"> -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

  <!-- CSS for FullCalendar -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" rel="stylesheet" />
  <!-- JS for jQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!-- JS for FullCalendar -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
  <!-- Bootstrap CSS and JS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"/>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

  <!-- Your custom CSS (make sure this is loaded after the external CSS) -->
  <link href="../global_assets/css/output.css" rel="stylesheet">
  <!-- <link href="./../global_assets/css/global_footer.css" rel="stylesheet"> -->
</head>

<body class="flex flex-row min-w-screen">

  <!-- Left Sidebar -->
  <div class="slide-panel" id="sidebar-content">
    <?php include './../global_components/sidebar.php';?>
  </div>

  <!-- Rest is main content -->
  <div class="flex flex-col w-screen max-w-screen min-h-screen">

    <!-- Header -->
    <header class="flex flex-row bg-blue-500 text-white p-1 btn-slide">
      <a class="p-2 text-2xl hover-action" id="btn-menu-list" onclick="slideOpen()"><i class='bx bx-menu'></i></a>
      <h1 class="p-2 text-2xl"><?php echo $page_full_name?></h1>
    </header>

    <!-- Main Object -->
    <main class="flex flex-col w-full h-full m-h-screen">

      <div class="p-base">
        <h1 class="p-title">Welcome back, Administrator!</h1>
      </div>

      <div class="p-base flex flex-row">
        <!-- about posts for event app -->
        <div class="flex flex-col w-1/2 p-3">
          <p class="bold">Upcoming Events</p>
          <div class="text-sm font-light text-[#6B7280] pb-8" bis_skin_checked="1">"Mark Your Calendars": Simplify date remembering.</div>

          <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1 gap-2
                      px-1 py-1" bis_skin_checked="1">
            <div class="max-h-12 w-full h-full bg-gray-300 rounded-xl p-2" bis_skin_checked="1">test</div>
            <div class="max-h-12 w-full h-full bg-gray-300 rounded-xl p-2" bis_skin_checked="1">test</div>
            <div class="max-h-12 w-full h-full bg-gray-300 rounded-xl p-2" bis_skin_checked="1">test</div>
            <div class="max-h-12 w-full h-full bg-gray-300 rounded-xl p-2" bis_skin_checked="1">test</div>
          </div>



        </div>

        <!-- Table -->
        <div class="flex flex-col w-1/2">
          <div class="p-calendar" id="calendar"></div>
        </div>
      </div>

    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white p-4 p-footer" id="p-footer">
      <p>All rights reserved <?php echo $proj_current_year?></p>
    </footer>

    <script src="./../global_assets/js/sidebar.js"></script>
    <script src="./../global_assets/js/calendar.js"></script>
  </div>

</body>
</html>