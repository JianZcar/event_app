<?php
  include "./../../proj_info.php";

  function page_name($page_name) {
    $page_full_name = "$page_name | $proj_name";
  }

  // Checking the username if exists
  function check_username($id, $username) {
    $sql_cmd = $db_conn->prepare("SELECT id, username FROM users WHERE username = ?");
    $sql_cmd->bind_param("s", $username);
    $sql_cmd->execute();
    $result = $sql_cmd->get_result();
    $row = $result->fetch_assoc();

    if ($row && $username == $row["username"] && $id != $row["id"]) {
      return FALSE;
    } else {
      return TRUE;
    }
  }

  function session
?>