<!-- Sidebar section applies for all pages -->
<div class="sidebar-top">
  <div class="text-4xl p-4 w-full flex flex-row">
    <i class='bx bxs-calendar-event'></i>
    <span class="set-hide text-xl"><?php echo $proj_name?></span>
  </div>
</div>

<div class="slide-profile">
    <img class="slide_profile_img" src="./../global_assets/img/default_user.png" alt="me">
    <div class="sidebar-profile-user set-hide">
      <p class="bold">Marc Buday</p>
      <p class="" >Admin</p>
    </div>
</div>

<ul class="sidebar-menu">
  

  <li class="slide-list">
    <a class="w-full flex flex-direction" href="./index.php">
      <i class="text-4xl bx bx-home"></i>
      <span class="set-hide">Home</span>
    </a>
  </li>

  <li class="slide-list">
    <a class="w-full flex flex-direction" href="./inbox.php">
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
    <a class="w-full flex flex-direction" href="#">
      <i class="text-4xl bx bx-log-out"></i>
      <span class="set-hide">Logout</span>
    </a>
  </li>
</ul>