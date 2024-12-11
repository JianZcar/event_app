<!-- Sidebar section applies for all pages -->
<?php

function sidebar_init() {
?>
<div class="sidebar-top">
  <div class="text-4xl p-4 w-full flex flex-row">
    <i class='bx bxs-calendar-event'></i>
    <span class="set-hide text-xl"><?php global $proj_name; echo $proj_name ?></span>
  </div>
</div>

<!-- <div class="slide-profile focus:brightness-50">
  <img class="slide_profile_img" src="./../global_assets/img/default_user.png" alt="me">
  <div class="sidebar-profile-user set-hide">    
    <p class="bold">Marc Buday</p>
    <p class="">Admin</p>
  </div>
</div> -->
<div class="slide-profile focus:bg-slate-400" onclick="window.location.href='./profile.php'">
  <img class="slide_profile_img" src="./../global_assets/img/default_user.png" alt="me">
  <div class="sidebar-profile-user set-hide">    
    <p class="bold"><?php echo $_SESSION['username'];?>
    </p>
    <p class=""><?php echo $_SESSION['role_name'];?></p>
  </div>
</div>

<ul class="bg-inherit text-slate-900 dark:bg-inherit dark:text-white">

  <li class="slide-list">
    <a class="w-full flex flex-direction" href="./index.php">
      <i class="text-4xl bx bx-home"></i>
      <span class="set-hide">Home</span>
    </a>
  </li>

  <li class="slide-list">
    <a class="w-full flex flex-direction" href="./posts.php">
      <i class="text-4xl bx bxs-inbox"></i>
      <span class="set-hide">Inbox</span>
    </a>
  </li>

  <li class="slide-list">
    <a class="w-full flex flex-direction" href="./calendar.php">
      <i class="text-4xl bx bx-calendar"></i>
      <span class="set-hide">Calendar</span>
    </a>
  </li>

  <li class="slide-list">
    <a class="w-full flex flex-direction" href="./user_management.php">
      <i class="text-4xl bx bxs-user-account"></i>
      <span class="set-hide">Admin Panel</span>
    </a>
  </li>

  <li class="slide-list">
    <a class="w-full flex flex-direction" href="./../login/components/logout.php">
      <i class="text-4xl bx bx-log-out"></i>
      <span class="set-hide">Logout</span>
    </a>
  </li>
</ul>
<?php
}
?>