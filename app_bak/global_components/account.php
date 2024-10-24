<?php
  include "./../../proj_info.php";


  // Check the username if there's exists when edit mode section
  function check_username($conn, $id, $username) {
    // Prepare the SQL statement using heredoc syntax
    $sql_cmd = <<<SQL
    SELECT id, username 
      FROM users 
      WHERE username = '{$username}'
    SQL;

    $result = $conn->query($sql_cmd);
    $query = $result->fetch_assoc();

    // Check if the username is exists
    if ($query && $username == $query["username"] && $id != $query["id"]) {
      return FALSE;
    } else {
      return TRUE;
    }
  }

  function session_announce($msg, $goto_require, $goto_php) {
    // $msg : Message to be displayed
    // $goto_require : If the redirection is required just say TRUE.
    // $goto_php : The redirection page

    $_SESSION['msg_account_announce'] = $msg;
    if ($goto_require) {
      header("Location: $goto_php");
    } 
  }

  function password_encoder($password) {
    // $password : Encode the password to be hashed
    return password_hash($password, PASSWORD_DEFAULT);
  }

  function sql_execute($conn, $sql) {
    // $conn : Database connection
    // $sql : SQL query command to be executed

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      return $result;
    } else {
      return FALSE;
    }
  }

  function exec_login($conn, $username, $password) {
    // $conn : Database connection
    // $username : Username
    // $password : Password

    // Check if the username and password is correct
    $sql_cmd = <<<SQL
    SELECT id, username, passwd, is_active, user_role
      FROM users
      WHERE username = '{$username}'
    SQL;

    $result = sql_execute($conn, $sql_cmd);
    if ($result) {
      $row = $result->fetch_assoc();
      if (password_verify($password, $row['passwd'])) {

        // I will add soon if admin or not (aceday)

        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['user_role'] = $row['user_role'];
        $_SESSION['is_active'] = $row['is_active'];
        header("Location: index.php");
      } else {
        session_announce("Username or password is incorrect.", TRUE, "/");
      }
    } else {
      session_announce("Username or password is incorrect.", TRUE, "/");
    }
  }

  function exec_logout() {
    // Log out the user
    session_destroy();
    header("Location: /");
  }
?>