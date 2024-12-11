<?php
function profile_card() {
    global $db_conn;

    // Fetch image

?>
<div class="p-base">
    <h1 class="p-title">Welcome back, <?php echo $_SESSION['username'];?></h1>
</div>

<div class="p-base">
    <div class="rounded-xl bg-slate-50 p-4 h-48 min-h-48">
        <div class="profile-img items-center justify-items-center">
            <img class="w-20 h-20 rounded-full border-2" src="./../global_assets/img/default_user.png" alt="">
        </div>
        <img src="" alt="">
    </div>
    <h1 class="p-title">Welcome back, <?php echo $_SESSION['username'];?></h1>
</div>
<?php
}
?>