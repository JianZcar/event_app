<?php
include_once "./../global_components/base.php";
global $db_conn;

function register_auth($username, $password, $email) {
    /**
     * Register a new user
     * 
     * @param string $username
     * @param string $password
     * @param string $email
     * @return bool TRUE on success, FALSE on failure
     */

    global $db_conn;
    $user_role = 2; // Default user role
    $is_active = 1; // Default user status

    try {
        // Hash the password before storing it
        $hashed_password = password_encoder($password);

        $sql_cmd = $db_conn->prepare("INSERT INTO users (username, passwd, user_role, is_active) VALUES (?, ?, ?, ?)");
        $sql_cmd->bind_param("ssii", $username, $hashed_password, $user_role, $is_active);
        $sql_cmd->execute();

        if ($sql_cmd->affected_rows > 0) {

            // Get the user's id from the last insert
            $sql_cmd_get_id = $db_conn->prepare("SELECT id FROM users WHERE username = ?");
            $sql_cmd_get_id->bind_param("s", $username);
            $sql_cmd_get_id->execute();
            $result = $sql_cmd_get_id->get_result();
            $row = $result->fetch_assoc();
            $id = $row['id'];
            $sql_cmd_get_id->close();

            // Insert user's email into user_infos table
            $sql_cmd_user_infos = $db_conn->prepare("INSERT INTO user_infos (id, email) VALUES (?, ?)");
            $sql_cmd_user_infos->bind_param("is", $id, $email);
            $sql_cmd_user_infos->execute();
            $sql_cmd_user_infos->close();

            // return true;
//            session_announce("Account created successfully", true, "index.php");
            header("Location: ./../login/");
        } else {
            header("Location: ./../login/register.php");
//            session_announce("Account creation failed", true, "register.php");
            // return false;
        }
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo $e->getMessage();

        // Debugginge purposes
//        session_announce($e ->getMessage(), true,"register.php");
        // return false;
    } finally {
        if (isset($sql_cmd)) {
            $sql_cmd->close();
            exit();
        }
    }
}

function get_user_while_login() {
    /**
     * Get user details while logging in
     * ONGOING
     */
    global $db_conn;

    try {
        $sql_cmd = $db_conn->prepare("SELECT * FROM users WHERE username = ?");
        $sql_cmd->bind_param("s", $username);
        $sql_cmd->execute();
        $result = $sql_cmd->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
        } else {
            return null;
        }
    } catch (Exception $e) {
        error_log($e->getMessage());
        return null;
    } finally {
        $sql_cmd->close();
        exit();
    }
}

function login_auth($username, $password) {
    /**
     * Authenticate user login
     * 
     * @param string $username
     * @param string $password
     * @return bool TRUE on success, FALSE on failure
     */

    global $db_conn;

    try {
        $sql_cmd = $db_conn->prepare("
            SELECT 
                users.id,
                users.username, 
                users.passwd,
                users.user_role,
                user_roles.role_name,
                user_roles.color,
                user_roles.bg_color
            FROM 
                users 
            INNER JOIN 
                user_roles 
            ON 
                users.user_role = user_roles.id
            WHERE 
                users.username = ?
        ");

        $sql_cmd->bind_param("s", $username);
        $sql_cmd->execute();
        $result = $sql_cmd->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            if (password_verify($password, $row['passwd'])) {
                // session_start();
                session_regenerate_id(true);

                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['user_role'] = $row['user_role'];
                $_SESSION['color'] = $row['color'];
                $_SESSION['bg_color'] = $row['bg_color'];
                $_SESSION['is_active'] = 1;
                $_SESSION['role_name'] = $row['role_name'];

                // WHEN WE WOULD BE USING HTTPS IN THAT CASE
                // Set HttpOnly flag on the session cookie
                // if (!ini_set('session.cookie_httponly', 1)) {
                //     throw new Exception("Failed to set session.cookie_httponly");
                // }

                // // Set secure flag on the session cookie if using HTTPS
                // if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                //     if (!ini_set('session.cookie_secure', 1)) {
                //         throw new Exception("Failed to set session.cookie_secure");
                //     }
                // }
            
                // If admin or guest but for default it should be admin only
//                session_announce("", true, "./../admin/");
                header("Location: ./../admin/");
                // return true;
            } else {
                // Invalid password
//                session_announce("Invalid Username or Password", true, "index.php");
                header("Location: ./../login/");
                return false;
            }
        } else {
            // Username not found
//            session_announce("Username not found", true, "index.php");
            header("Location: ./../login/");
             return false;
        }
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo $e->getMessage();
        $_SESSION['msg_account_announce'] = "An error occurred. Please try again.";
        return false;
    } finally {
        $sql_cmd->close();
        exit();
    }
}

function logout_auth($call) {
    /**
     * Logout user
     * 
     * @param bool $call if any value is input, session_start() will not be called
     */
    if (!isset($call)) {
        session_start();
    }
    session_unset();
    session_destroy();
    header("Location: /app/login/");
    exit();
}


function get_auth_if_exists() {
    if (isset($_SESSION['user_id'])) {
        header("Location: ./../admin/");
        exit();
    }   
}
?>
