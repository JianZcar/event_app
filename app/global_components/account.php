<?php
include_once "./../../proj_info.php";

function check_user_exist($user_id) {
	/**
	 * Check if the user ID is invalid.
	 *
	 * @param int $user_id User ID
	 */
	if (!isset($user_id) || !is_numeric($user_id)) {
		session_announce("User ID not set.", true, "/app/admin/user_management.php");
	}
}
function user_lists($is_command_only) {
	/**
	 * Get a list of users.
	 */
	global $db_conn;
	$sql_cmd = "SELECT
					users.id,
					users.username,
					users.is_active,
					user_roles.role_name,
					user_roles.color,
					user_roles.bg_color
				FROM
					users
				INNER JOIN
					user_roles
				ON users.user_role = user_roles.id;";
	if ($is_command_only) {
		return $sql_cmd;
	} else {
		$result = $db_conn->query($sql_cmd);
		return $result;
	}
}

function user_type_status($role_id) {
}

function get_user_email($user_id) {
  /**
   * Get the email of a user.
   *
   * @param int $user_id User ID
   * @return string|null Email address or null if not found
   */
  global $db_conn;
  $sql_cmd = "SELECT email FROM user_infos WHERE id = ?";
  $stmt = $db_conn->prepare($sql_cmd);
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  return $row ? $row['email'] : null;
}

function session_auth_daemon(): void {
  /**
   * Starts a session and checks if the user is logged in.
   */
  if (!isset($_SESSION['user_id'])) {
    session_announce("You need to login first", true, "/app/login/");
  } else {
    // Check role
    if ($_SESSION['user_role'] != 1) {
      session_announce("You are not authorized to access this page", true, "/app/login/");
      session_unset();
      session_destroy();
    }
  }
}

function change_password($conn, $id, $new_password) {
	/**
	 * Changes a user's password.
	 *
	 * @param mysqli $conn Database connection
	 * @param int $id User ID
	 * @param string $new_password New password
	 * @return bool TRUE on success, FALSE on failure
	 */

}
// Check the username if there's exists when edit mode section
function check_username(mysqli $conn, int $id, string $username): bool {
	/**
	 * Checks if a username exists in the database.
	*
	* @param mysqli $conn Database connection
	* @param int $id User ID
	* @param string $username Username to check
	* @return bool TRUE if username does not exist, FALSE otherwise
	*/

	$sql_cmd = "SELECT id, username FROM users WHERE username = ?";

	$stmt = $conn->prepare($sql_cmd);
	$stmt->bind_param("s", $username);
	$stmt->execute();
	$result = $stmt->get_result();
	$query = $result->fetch_assoc();

	if ($query && $username === $query["username"] && $id !== $query["id"]) {
		return false;
	} else {
		return true;
	}
}

function session_announce(string $msg, bool $goto_require, string $goto_php): void {
	/**
	 * Sets a session announcement message and redirects if required.
	 *
	 * @param string $msg Announcement message
	 * @param bool $goto_require_once Whether redirection is required
	 * @param string $goto_php Redirection page URL
	 */

	$_SESSION['msg_account_announce'] = $msg;

	if ($goto_require) {
		header("Location: $goto_php");
		exit();
	}
}

function password_encoder(string $password): string {
	/**
	 * Hashes a password using the default algorithm.
	 *
	 * @param string $password Password to be hashed
	 * @return string Hashed password
	 */
	return password_hash($password, PASSWORD_DEFAULT);
}

function sql_execute(mysqli $conn, string $sql): mysqli_result|false {
	/**
	 * Executes an SQL query and returns the result.
	 *
	 * @param mysqli $conn Database connection
	 * @param string $sql SQL query command
	 * @return mysqli_result|false Result or FALSE on failure
	 */
	$result = $conn->query($sql);
	return ($result && $result->num_rows > 0) ? $result : false;
}

function exec_login(mysqli $conn, string $username, string $password): void {
  /**
   * Executes login functionality.
   *
   * @param mysqli $conn Database connection
   * @param string $username Username
   * @param string $password Password
   */
  $sql_cmd = "SELECT id, username, passwd, is_active, user_role 
                FROM users 
                WHERE username = ?";

  $stmt = $conn->prepare($sql_cmd);
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();

  if ($row) {
    if (password_verify($password, $row['passwd'])) {
      $_SESSION['user_id'] = $row['id'];
      $_SESSION['username'] = $row['username'];
      $_SESSION['user_role'] = $row['user_role'];
      $_SESSION['is_active'] = $row['is_active'];
      header("Location: index.php");
      exit;
    } else {
      session_announce("Invalid credentials.", true, "/");
    }
  } else {
    session_announce("Invalid credentials.", true, "/");
  }
}

function exec_logout(): void {
	/**
	 * Logs out the user and redirects to the homepage.
	 */
	session_unset();
	session_destroy();
	header("Location: /");
	// exit;
}