<?php
include_once "./dialog.php";
include_once "./account.php";
function exec_login($username, $password) {
    include_once "./../../proj_info.php";

    if (empty($username) || empty($password)) {
        sessuion_announce("Please fill in all fields.", true, "./index.php");
    }

    // Prepare query
    $sql_cmd = "SELECT id, username, passwd FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql_cmd);
    $stmt->bind_param("s", $username);

    // Execute query
    $stmt->execute();

    // Get results
    $result = $stmt->get_result();
    $query = $result->fetch_assoc();

    // Check if username exists
    if (!$query) {
        session_announce("Username does not exist.", true, "./index.php");
    } else {
        // Check if password is correct
        if (password_verify($password, $query["passwd"])) {
            // Set session variables
            $_SESSION["user_id"] = $query["id"];
            $_SESSION["username"] = $query["username"];
            $_SESSION["logged_in"] = true;

            // Redirect to home page
            header("Location: ./../home/index.php");
            exit;
        } else {
            session_announce("Incorrect password.", true, "./index.php");
        }
    }
}
?>