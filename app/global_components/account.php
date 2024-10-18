<?php
  include "./../../proj_info.php";

  function check_username($conn, $id, $username) {
    // Prepare the SQL statement using heredoc syntax
    $sql_cmd = <<<SQL
    SELECT id, username 
      FROM users 
      WHERE username = '{$username}'
    SQL;

    // Execute the query
    $result = $conn->query($sql_cmd);
    $query = $result->fetch_assoc();

    // Check if the username exists and if the ID does not match
    if ($query && $username == $query["username"] && $id != $query["id"]) {
      return FALSE;
    } else {
      return TRUE;
    }
  }

  function session_announce($msg, $goto_require, $goto_php) {
    $_SESSION['msg_account_announce'] = $msg;
    if ($goto_require) {
      header("Location: $goto_php");
    } 
  }

  function password_encoder($password) {
    return password_hash($password, PASSWORD_DEFAULT);
  }
?>