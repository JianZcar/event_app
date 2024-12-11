<?php
function get_posts($limit) {
    global $db_conn;

    if (!isset($limit)) {
        $limit = 12;
    }

    $sql_posts = "SELECT * FROM event_posts;";

    if (isset($_GET['page']) && is_numeric($_GET['page'])) {
        // if theres greather than last page it will redirect to the last page
        // if ($_GET['page'] > $records[1]) {
        //   header("Location: posts.php?page=" . $records[1]);
        // } else if ($_GET['page'] < 1) {
        //   header("Location: posts.php?page=1");
        // } else {

        // }
        $records = paginate($db_conn, $sql_posts, $_GET['page'], $limit);
    } else {
        $records = paginate($db_conn, $sql_posts, 0, $limit);
    }
    
    return $records;

}