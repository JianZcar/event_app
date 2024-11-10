<?php
include_once "pagination.php";

function post_lists($conn, $user_id, $toggle_pagination=true, $page=1, $limit=5) {
    $sql_posts = "SELECT subject_name, id, content, start_datetime, end_datetime FROM event_posts";
    if ($toggle_pagination) {
        $result_posts = paginate($conn, $sql_posts, $page, $limit);
    } else {
        $result_posts = $conn->query($sql_posts);
    }

    // for loop array to save the data
    $posts = [];
    while ($row = $result_posts->fetch_assoc()) {
        $post = [
            "subject_name" => $row["subject_name"],
            "id" => $row["id"],
            "content" => $row["content"],
            "start_datetime" => $row["start_datetime"],
            "end_datetime" => $row["end_datetime"],
        ];
        array_push($posts, $post);
    }
    return $posts;
}

function check_post_exist($post_id) {
    if (!isset($post_id) || !is_numeric($post_id)) {
        session_announce("Invalid post ID.", true, "./posts.php");
        exit();
    }
}
function view_post($post_id, $user_id) {
    /**
     * Get information post
     * @param int $post_id
     * @param int $user_id
    */

    global $db_conn;
    // Get information post
    $sql_cmd = "SELECT 
                    subject_name, 
                    id, 
                    content, 
                    start_datetime, 
                    end_datetime, 
                    created_at, 
                    updated_at 
                FROM 
                    event_posts 
                WHERE 
                    id = ?";
    $sql_query = $db_conn->prepare($sql_cmd);
    $sql_query->bind_param("i", $post_id);
    $sql_query->execute();
    $result = $sql_query->get_result();

    // Check if post exists
    if ($result->num_rows === 0) {
        session_announce("Post not found.", true, "./posts.php");
        exit();
    }

    $row = $result->fetch_assoc();

    // Format dates
    $post_id = $row['id'];
    $subject_name = $row['subject_name'];
    $content = $row['content'];
    $start_datetime = date_format(date_create($row['start_datetime']), "F d, Y h:i A");
    $end_datetime = date_format(date_create($row['end_datetime']), "F d, Y h:i A");
    $updated_at = date_format(date_create($row['updated_at']), "F d, Y h:i A");
    $created_at = date_format(date_create($row['created_at']), "F d, Y h:i A");

    // Determine post status
    $post_status = date_status($start_datetime, $end_datetime);

    $row['post_status'] = $post_status;
    $row['subject_name'] = $subject_name;
    $row['content'] = $content;
    $row['start_datetime'] = $start_datetime;
    $row['end_datetime'] = $end_datetime;
    $row['updated_at'] = $updated_at;
    $row['created_at'] = $created_at;
    
    return $row;
}


function edit_post_update($post_id, $post_contents, $user_id) {
    /**
     * Edit post
     * @param int $post_id
     * @param array $post_contents
     * @param int $user_id
     */

    // Check post content
    if (strlen($post_contents['subject_name']) == 0) {
        session_announce("Please fill in all fields.", true, "edit_posts.php?id=$post_id");
        exit();
    }
    // if (strtotime($post_contents['start_datetime']) > strtotime($post_contents['end_datetime'])) {
    //     session_announce("End date must be greater than start date.", true, "./edit_posts.php?id=$post_id");
    //     exit();
    // }
    // if (strtotime($post_contents['start_datetime']) < strtotime(date("Y-m-d H:i:s"))) {
    //     session_announce("Start date must be greater than current date.", true, "./edit_posts.php?id=$post_id");
    //     exit();
    // }
    // if (strtotime($post_contents['end_datetime']) < strtotime(date("Y-m-d H:i:s"))) {
    //     session_announce("End date must be greater than current date.", true, "./edit_posts.php?id=$post_id");
    //     exit();
    // }
    // if (strtotime($post_contents['start_datetime']) == strtotime($post_contents['end_datetime'])) {
    //     session_announce("Start date and end date cannot be the same.", true, "./edit_posts.php?id=$post_id");
    //     exit();
    // }
    // if (strlen($post_contents['content']) > 0) {
    //     session_announce("The content must ", true, "./edit_posts.php?id=$post_id");
    //     exit();
    // }
    global $db_conn;
    // Get information post
    $sql_cmd = "UPDATE
                    event_posts
                SET
                    subject_name = ?,
                    content = ?,
                    start_datetime = ?,
                    end_datetime = ?,
                    updated_at = NOW()
                WHERE
                    id = ?";

    $sql_query = $db_conn->prepare($sql_cmd);
    $sql_query->bind_param("ssssi", $post_contents['subject_name'], $post_contents['content'], $post_contents['start_datetime'], $post_contents['end_datetime'], $post_id);
    $sql_query->execute();

    // Check if post is updated
    if ($sql_query->affected_rows == 1) {
        session_announce("Post updated successfully.", true, "./view_posts.php?id=$post_id");
    } else {
        session_announce("Failed to update post.", true, "posts.php");
    }
}


function edit_post($post_id, $user_id) {
    /**
     * Check if the user is the owner of the post
     * @param int $post_id
     * @param int $user_id
     */
        global $db_conn;
        // Get information post
        $sql_cmd = "SELECT subject_name, id, content, start_datetime, end_datetime, created_at, updated_at, user_id FROM event_posts WHERE id = ?";
        $sql_query = $db_conn->prepare($sql_cmd);
        if ($sql_query === false) {
            die('Prepare failed: ' . htmlspecialchars($db_conn->error));
        }
        $sql_query->bind_param("i", $post_id);
        $sql_query->execute();
        $result = $sql_query->get_result();
        
        // Check if post exists
        if ($result->num_rows === 0) {
            session_announce("Post not found.", true, "./posts.php");
            exit();
        } else {
            // Check if the user is the owner of the post
            $row = $result->fetch_assoc();

            if ($row['user_id'] !== $user_id) {
                // Put it false
                // return $row;
                // session_announce("You are not the owner of this post.", true, "./posts.php");
                return $row;

            } else {
                return $row;
            }
            exit();
        }
}
?>