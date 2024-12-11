<?php
  include_once('./../../proj_info.php');

  $page_name = "User";
  $page_full_name = "$page_name | $proj_name";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $page_full_name?></title>
  <link href="../global_assets/css/output.css" rel="stylesheet">
  <link href="./../global_assets/css/global_footer.css" rel="stylesheet">
  <link href="./../global_assets/css/panel.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
<header class="bg-blue-500 text-white p-4">
  <h1 class="text-2xl"><?php echo $page_full_name?></h1>
</header>
<main class="p-4 p-body">
  <p>Main content goes here.</p>
  <div class="panel-base p-title">
    <h1>Username</h1>
  </div>

  <div class="panel-base p-profile">
    <div class="profile-cover">
      <img src="./../global_assets/img/default_user.png">
    </div>
  
    <div class="profile-name-sec">
      <h2>Juan Dela Cruz</h2>
      <p>
        <span>Username: </span>
        <span>john_doe</span>
      </p>
    </div>
  </div>

  <div class="panel-base p-poster">
    Write Post
    <form>
      <textarea name="post" id="post" cols="30" rows="3"></textarea>
      <button type="submit">Post</button>
    </form>
  </div>

  <div class="panel-base p-title">
    <h1>Events</h1>
  </div>


  <div class="panel-base">
    Test
  </div>
</main>
<footer class="bg-gray-800 text-white p-4 p-footer">
  <p>All rights reserved <?php echo $proj_current_year?></p>
</footer>
</body>
</html>
