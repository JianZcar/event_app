<?php
  include "./../../proj_info.php";
?>

<?php 
function dialog_user_add() {
?>
<div class="p-base flex flex-row justify-between items-center">
  <p>Here's a list of users.</p>
  <button class="btn-accept-1" onclick="window.location.href='./add_user.php'">Add</button>
</div>
<?php
}
?>

<?php
function form_user_add() {
  /**
   * Add user form - POST method
   */
  global $db_conn;
  global $master_debug;
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // START CHECK
    /**
     * EXAMPLE USA
     * PART 1 -->
     * INSERT INTO
     *    users
     *        (username, passwd, is_active, user_role, profile_picture)
     * VALUES
     *       ('aceday15', 'aceday15', 1, 1, profile_picture);
     * 
     * PART 2 -->
     * INSERT INTO
     *    user_infos
     *       (email, id)
     * VALUES
     *      ('aceday15@aceday15.com', LAST_INSERT_ID());
     */

    $sql_cmd = "INSERT INTO users (username, passwd, is_active, user_role, profile_picture) VALUES (";

    // ------ START OF PART 1 ------
    // Table: users

    // POST Username
    $username = $_POST['username'];
    $sql_cmd .= "'$username', ";
    
    // POST Password
    $password = password_encoder($_POST['password']);
    $sql_cmd .= "'$password', ";

    // POST is_active
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    $sql_cmd .= "$is_active, ";

    // POST Role
    $role = $_POST['role'];
    $sql_cmd .= "$role ";
    if (($role != 1 && $role != 2) || empty($role)) {
      session_announce("Please fill all fields correctly.", TRUE, "add_user.php");
    }

    // POST Profile Picture if exist or not
    $target_dir = "./tmp/";

    // ~aceday - Need to fix this
    if (!empty($_FILES['profileUpload']['name'])) {
      
      $profile_picture_filename = basename($_FILES['profileUpload']['name']);
      $profile_picture_tmp_name = $_FILES['profileUpload']['tmp_name'];
      $profile_picture_target = "{$target_dir}{$profile_picture_filename}";
      $file_type = pathinfo($profile_picture_filename, PATHINFO_EXTENSION);

      // File type validation
      $allow_types = ['jpeg', 'jpg', 'png', 'gif'];

      if (in_array($file_type, $allow_types)) {
        // Matched file type
        if (move_uploaded_file($profile_picture_tmp_name, $profile_picture_target)) {
          // Append with $sql_cmd
          $sql_cmd .= "'$profile_picture_filename', ";
        } else {
          session_announce("Error uploading file.", TRUE, "add_user.php");
        }
      } else {
        session_announce("Invalid image type.", TRUE, "add_user.php");
      }
    } else {
      $sql_cmd .= ", NULL";
    }

    // End for comma
    $sql_cmd .= ");";

    if ($master_debug) {
      echo $sql_cmd;
      exit();
    }

    // Execute the query
    $db_conn->query($sql_cmd);
    // $db_conn->close();
    // ------ END OF PART 1 ------



    // ------ START OF PART 2 ------
    // Table: user_infos

    // del($sql_cmd);
    $sql_cmd = "INSERT INTO user_infos (id, email) VALUES (";

    // POST ID
    $get_id = $db_conn->query("SELECT id FROM users WHERE username = '$username';");
    if ($get_id->num_rows == 1) {
      $result_id = $get_id->fetch_assoc();
      $sql_cmd .= $result_id['id'] . ", ";
    }

    // POST email
    $email = $_POST['email'];
    $sql_cmd .= "'$email'";

    // End for comma
    $sql_cmd .= ");";

    echo $sql_cmd;
    // exit();



    // Get the last insert id after created user in users
    
    if ($db_conn->query($sql_cmd)) {
      session_announce("User created successfully.", TRUE, "user_management.php");
    } else {
      session_announce("Error creating user: " . $db_conn->error, TRUE, "add_user.php");
    }
  }
?>
<div class="p-base">
  <div class="flex flex-col w-full md:w-1/2 xl:w-2/5 2xl:w-2/5 3xl:w-1/3 mx-auto p-8 md:p-10 2xl:p-12 3xl:p-14 bg-white rounded-2xl shadow-xl">
    <form class="flex flex-col" method="post">
      <div class="pb-6">
        <label for="username" class="block mb-2 text-sm font-medium text-[#111827]">Username</label>
        <div class="relative text-gray-400">
          <input type="text" name="username" id="username" class="p-textbox" placeholder="Username" autocomplete="off" value="" required>
        </div>
      </div>
      <div class="pb-6">
        <label for="password" class="block mb-2 text-sm font-medium text-[#111827]">Password</label>
        <div class="relative text-gray-400">
          <input type="password" name="password" id="password" class="p-textbox" autocomplete="new-password" placeholder="Password" minlength="8" required>
        </div>
      </div>
      <div class="pb-6 flex flex-row justify-between">
        <label for="is_active" class="block mb-2 text-sm font-medium text-[#111827]">Active</label>
        <div class="relative text-gray-400">
          <input type="checkbox" name="is_active" id="is_active" class="checkbox-1">
        </div>
      </div>
      <div class="pb-6">
        <label for="email" class="block mb-2 text-sm font-medium text-[#111827]">Email</label>
        <div class="relative text-gray-400">
          <input type="email" name="email" id="email" class="p-textbox" placeholder="Email" autocomplete="off" value="" required>
        </div>
      </div>
      <div class="pb-6">
        <label for="role" class="block mb-2 text-sm font-medium text-gray-900">Role Type</label>
        <select name="role" id="role" class="selection-drop-1" required>
          <option selected disabled>Choose a role</option>
          <option value="1">Admin</option>
          <option value="2">User</option>
        </select>
      </div>
      <div class="pb-6">
        <label for="profileUpload">Profile Picture</label>
        <input class="form-file-upload" type="file" name="profileUpload">
      </div>
      <button type="submit" class="btn-post-accept-1">Add User</button>
      <a type="submit" class="btn-post-danger-1" href="./user_management.php">Cancel</a>
    </form>
  </div>
</div>
<?php
exit();
  }
?>


<?php
function form_user_edit() {
  /**
   * Edit user form - POST method
   */
  global $db_conn;
  global $master_debug;

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Checking if username exists or not
    if (!check_username($db_conn, $_GET["id"], $_POST["username"])) {
      session_announce("Username already exists.", TRUE, "./edit_user.php?id={$_GET['id']}");
    } else {

      // START CHECK
      // $sql_cmd = "UPDATE users SET username = ?, is_active = ?, user_role = ?, profile_picture = ?";

      /**
       * EXAMPLE USAGE
       * 
       * UPDATE
       *   users
       * JOIN
       *   user_infos ON users.id = user_infos.id
       * SET 
       *   users.username = 'aceday15', 
       *   users.passwd = 'aceday15',
       *   users.is_active = 1,
       *   users.user_role = 1,
       *   user_infos.email = 'aceday15@aceday15.com'
       *   users.profile_picture = 'profile_picture.jpg'
       * WHERE
       *   users.id = 52;
       */

      $sql_cmd = "UPDATE users JOIN user_infos ON users.id = user_infos.id SET ";
    
      // POST Username
      $uname = $_POST["username"];
      $sql_cmd .= "users.username = '$uname', ";

      // POST Password
      if (!empty($_POST["password"])) {
        $password = password_encoder($_POST["password"]);
        $sql_cmd .= "users.passwd = '$password', ";
      }

      // POST is_active
      $is_active = isset($_POST["is_active"]) ? 1 : 0;
      $sql_cmd .= "users.is_active = $is_active, ";

      // POST Role
      $role = $_POST["role"];
      $sql_cmd .= "users.user_role = $role, ";

      // POST Email
      $email = $_POST["email"];
      $sql_cmd .= "user_infos.email = '$email' ";

      // Upload image profile_picture is a variable name so it can upload to mysql and its mediumblob
      $target_dir = "./tmp/";
      if (!empty($_FILES['profileUpload']['name'])) {

        $profile_picture_filename = basename($_FILES['profileUpload']['name']);
        $profile_picture_tmp_name = $_FILES['profileUpload']['tmp_name'];
        $profile_picture_target = $target_dir . $profile_picture_filename;
        $file_type = pathinfo($profile_picture_filename, PATHINFO_EXTENSION);

        // if ($master_debug) {
        //   echo "$profile_picture_filename\n";
        //   echo "$profile_picture_tmp_name\n";
        //   echo "$profile_picture_target\n";
        //   echo $file_type;
        //   exit();
        // }
        // File type validation
        $allow_types = array('jpeg', 'jpg', 'png', 'gif');

        if (in_array($file_type, $allow_types)) {

          // Matched file type
          $sql_cmd .= ", users.profile_picture = '$profile_picture_filename' ";
          
          // NEED TO FIX THIS ~ aceday
          // if (move_uploaded_file($profile_picture_tmp_name, $profile_picture_target)) {
          //   // Append with $sql_cmd
          //   $sql_cmd .= ", users.profile_picture = '$profile_picture_filename' ";
          // } else {
          //   session_announce("Error uploading file.", TRUE, "./edit_user.php?id={$_GET['id']}");
          // }

        } else {
          session_announce("Invalid image type.", TRUE, "./edit_user.php?id={$_GET['id']}");
        }
      }

      // End for comma
      $sql_cmd .= "WHERE users.id = {$_GET['id']};";

      if ($master_debug) {
        echo $sql_cmd;
      }

      if ($db_conn->query($sql_cmd) === TRUE) {
        session_announce("User {$_POST['username']} updated successfully.", TRUE, "user_management.php");
      } else {
        session_announce("Error updating user $uname: " . $db_conn->error, TRUE, "user_management.php");
      }
    }
  } else {

    // Display the user's data
    if (isset($_GET['id'])) {
      $user_id = $_GET['id'];
      $edit_mode = TRUE;

      // Prepare the query
      $sql_cmd = $db_conn->prepare("SELECT * FROM users WHERE id = ?");
      $sql_cmd->bind_param("i", $user_id);
      $sql_cmd->execute();
      $result = $sql_cmd->get_result();

      // Get email from user_infos
      $sql_cmd_email = $db_conn->prepare("SELECT email FROM user_infos WHERE id = ?");
      $sql_cmd_email->bind_param("i", $user_id);
      $sql_cmd_email->execute();
      $result_email = $sql_cmd_email->get_result();
      $email = $result_email->fetch_assoc()['email'];
      // Get the user's data
      if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $uname = htmlspecialchars($row['username']);
        $is_active = htmlspecialchars($row['is_active']);
        $role = htmlspecialchars($row['user_role']);
        // $email = htmlspecialchars($email ?? '', ENT_QUOTES, 'UTF-8');		
        $email = htmlspecialchars($email);						// Incompatible for developing with linux
      } else {
        session_announce("User ID not found.", TRUE, "./user_management.php");
        header("Location: user_management.php");
      }
    }

    if (isset($_SESSION['msg_account_announce'])) {
      $msg_account_announce = $_SESSION['msg_account_announce'];
    }
  }
?>
  <div class="p-base">
    <div class="flex flex-col w-full md:w-1/2 xl:w-2/5 2xl:w-2/5 3xl:w-1/3 mx-auto p-8 md:p-10 2xl:p-12 3xl:p-14 bg-[#ffffff] rounded-2xl shadow-xl">
      <form class="flex flex-col" method="post" enctype="multipart/form-data">
        <div class="pb-6">
          <label for="username" class="block mb-2 text-sm font-medium text-[#111827]">Username</label>
          <div class="relative text-gray-400">
            <input type="text" name="username" id="username" class="p-textbox" placeholder="Username" autocomplete="off" value="<?php echo $uname ?>">
          </div>
        </div>
        <div class="pb-6">
          <label for="password" class="block mb-2 text-sm font-medium text-[#111827]">Password</label>
          <div class="relative text-gray-400">
            <input type="password" name="password" id="password" placeholder="(Unchanged)" class="p-textbox" autocomplete="new-password">
          </div>
        </div>
        <div class="pb-6 flex flex-row justify-between">
          <label for="is_active" class="block mb-2 text-sm font-medium text-[#111827]">Active</label>
          <div class="relative text-gray-400">
            <input type="checkbox" name="is_active" id="is_active" class="checkbox-1" <?php echo $is_active ? 'checked' : ''; ?>>
          </div>
        </div>
        <div class="pb-6">
          <label for="email" class="block mb-2 text-sm font-medium text-[#111827]">Email</label>
          <div class="relative text-gray-400">
            <input type="email" name="email" id="email" class="p-textbox" placeholder="Email" autocomplete="off" value="<?php echo $email ?>">
          </div>
        </div>
        <div class="pb-6">
          <label for="role" class="block mb-2 text-sm font-medium text-gray-900">Role Type</label>
          <select name="role" id="role" class="selection-drop-1" required>
            <option value="1">Admin</option>
            <option value="2">User</option>
          </select>
        </div>
        <div class="pb-6">
          <label class="text-slate-900" for="profileUpload">Profile Picture</label>
          <input class="form-file-upload" type="file" name="profileUpload">
        </div>
        <button type="submit" class="btn-post-accept-1">Update User</button>
        <a href="./user_management.php" class="btn-post-common-1">Cancel</a>
        <!-- <a class="btn-post-danger-1" data-modal-target="default-modal" data-modal-toggle="default-modal">Delete</a> -->
        <a href="./delete_user.php?id=<?php echo $user_id ?>" class="btn-post-danger-1">Delete</a>
      </form>
    </div>
  </div>
<?php
  exit();
}
?>
