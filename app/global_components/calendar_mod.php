<?php

// Load full calendar from npm
function calendar_init_script() {
?>
<script src="/node_modules/fullcalendar/index.global.min.js"></script>
<?php
}?>

<?php
function get_events() {
    // Get all events from the database and load to full calendar js
    global $db_conn;
    $sql_events = <<<SQL
    SELECT 
        id,
        subject_name,
        content,
        start_datetime,
        end_datetime,
        user_id
        -- events.bg_color,
        -- events.user_id,
        -- users.username
    FROM 
        event_posts;
    SQL;
    // echo $sql_events;
    $result_events = $db_conn->query($sql_events);

    // Convert events to array
    $result_events = $result_events->fetch_all(MYSQLI_ASSOC);

    // Convert datetime to ISO8601 format
    foreach ($result_events as $key => $event) {
        // FROM: 2024-01-09 06:21:37
        // TO: 2024-01-09T06:21:37+00:00
        $result_events[$key]['start_datetime'] = date('c', strtotime($event['start_datetime']));
        $result_events[$key]['end_datetime'] = date('c', strtotime($event['end_datetime']));
    }

    return $result_events;
}

?>

<?php
// Render the calendar
function calendar_init() {
?>
<script src="/app/global_assets/js/calendar_init.js"></script>
<?php
}?>