<?php
session_start();
include_once "./../global_components/base.php";
web_start();

// Custom componets
include_once "./../global_components/account.php";
include_once "./../global_components/set_posts.php";
include_once "./../global_components/post_components.php";
include_once "./../global_components/post_query.php";

// Page Info
$page_name = "Admin Panel";
$page_full_name = page_full_name();

// POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$subject_name = $_POST['subject_name'];
$start_date = $_POST['start_date'];
$start_time = $_POST['start_time'];
$end_date = $_POST['end_date'];
$end_time = $_POST['end_time'];
$content = $_POST['content'];

// Combine date and time
$start_datetime = merge_datetime($start_date, $start_time);
$end_datetime = merge_datetime($end_date, $end_time);

create_post($subject_name, $start_datetime, $end_datetime, $content, $_SESSION['user_id']);

}
// Message Control
if (isset($_SESSION['msg_account_announce'])) {
    $msg_account_announce = $_SESSION['msg_account_announce'];
    unset($_SESSION['msg_account_announce']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php global_style(); ?>
    <title><?php echo $page_full_name ?></title>
    <?php global_first_js(); ?>
    <?php tinymce_js_init(); ?>
</head>
<body class="b-body">
    <div class="slide-panel" id="sidebar-content">
        <?php sidebar_init(); ?>
    </div>
    <div class="main-content">
        <form method="post">
            <?php global_header($page_full_name, $proj_name); ?>
            <main class="flex flex-col w-full h-full m-h-screen">
                <?php
                if (isset($msg_account_announce)) {
                    system_message($msg_account_announce);
                }
                ?>
                <?php post_create_subject_name(); ?>  
                <?php post_create_content(); ?> 
                <?php post_actions_1(); ?> 
            </main>
        </form>
        <?php global_footer(); ?>
        <?php global_last_js(); ?>
    </div>
</body>
</html>
