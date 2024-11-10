<?php

// Announce message
function msg_account_announce($message_announce) {
    if (isset($message_announce)) {
?>
    <div class="p-base">
        <p><?php echo $message_announce ?></p>
    </div>
<?php
    }
}
?>


<?php
// Bold message
function system_message_bold($message) {
    if (empty($username)) {
        $username = "Guest";
    }
?>
    <div class="p-base">
        <h1 class="p-title"><?php echo $message; ?>!</h1>
    </div>
<?php
}
?>

<?php
// Notify message
function system_message($message = "No message") {
?>
    <div class="p-base">
        <p><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></p>
    </div>
<?php
}
?>

<?php
// Search bar
function search_bar() {
?>
<div class="flex flex-row pb-2 space-x-4">
    <input class="p-textbox" placeholder="Type your name..">
        <button class="btn-search-1">Search</button>
</div>
<?php
}
?>