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
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    global $db_conn;
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    $role = $_POST['role'];

    if (($role != 1 && $role != 2) || empty($role)) {
      session_announce("Please fill all fields correctly.", TRUE, "add_user.php");
    } else {
      $password_hashed = password_encoder($password);
      $sql_cmd = "INSERT INTO users (username, passwd, is_active, user_role) VALUES ('$username', '$password_hashed', $is_active, $role)";
      if ($db_conn->query($sql_cmd) === TRUE) {

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

        session_announce("User created successfully.", TRUE, "user_management.php");

      } else {

        session_announce("Error creating user: " . $db_conn->error, TRUE, "add_user.php");

      }
      exit();
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
function form_user_edit($conn) {
  /**
   * Edit user form - POST method
   */
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Checking if username exists or not
    if (!check_username($conn, $_GET["id"], $_POST["username"])) {
      session_announce("Username already exists.", TRUE, "./edit_user.php?id={$_GET['id']}");
    } else {
      // START
      $uname = $_POST["username"];
      if (!empty($_POST["password"])) {
        $password = password_encoder($_POST["password"]);
      }
      $is_active = isset($_POST["is_active"]) ? 1 : 0;
      $role = $_POST["role"];
      
      if (!empty($password)) {
        $sql_cmd = <<<SQL
        UPDATE users SET username = '$uname', passwd = '$password', is_active = $is_active, user_role = $role WHERE id = {$_GET["id"]}; 
        SQL;
      } else {
        $sql_cmd = <<<SQL
        UPDATE users SET username = '$uname', is_active = $is_active, user_role = $role WHERE id = {$_GET["id"]};
        SQL;
      }

      if ($conn->query($sql_cmd) === TRUE) {
        // Update user's email
        if (!empty($_POST["email"])) {
          $sql_cmd_email = $conn->prepare("UPDATE user_infos SET email = ? WHERE id = ?");
          $sql_cmd_email->bind_param("si", $_POST["email"], $_GET["id"]);
          $sql_cmd_email->execute();
          $sql_cmd_email->close();
        }
        session_announce("User {$_POST['username']} updated successfully.", TRUE, "user_management.php");
      } else {
        session_announce("Error updating user $username: " . $conn->error, TRUE, "user_management.php");
      }
    }
  } else {
    if (isset($_GET['id'])) {
      $user_id = $_GET['id'];
      $edit_mode = TRUE;

      // Prepare the query
      $sql_cmd = $conn->prepare("SELECT * FROM users WHERE id = ?");
      $sql_cmd->bind_param("i", $user_id);
      $sql_cmd->execute();
      $result = $sql_cmd->get_result();

      // Get email from user_infos
      $sql_cmd_email = $conn->prepare("SELECT email FROM user_infos WHERE id = ?");
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
        $email = htmlspecialchars($email);
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
          <form class="flex flex-col" method="post">
            <div class="pb-6">
              <label for="username" class="block mb-2 text-sm font-medium text-[#111827]">Username</label>
              <div class="relative text-gray-400">
                <input type="text" name="username" id="username" class="p-textbox" placeholder="Username" autocomplete="off" value="<?php echo $uname ?>">
              </div>
            </div>
            <div class="pb-6">
              <label for="password" class="block mb-2 text-sm font-medium text-[#111827]">Password</label>
              <div class="relative text-gray-400">
                <input type="password" name="password" id="password" placeholder="(Unchanged)" class="p-textbox" autocomplete="new-password" placeholder="(Unchanged)">
              </div>
            </div>
            <div class="pb-6 flex flex-row justify-between">
              <label for="is_active" class="block mb-2 text-sm font-medium text-[#111827]">Active</label>
              <div class="relative text-gray-400">
                <input type="checkbox" name="is_active" id="is_active" class="checkbox-1" <?php echo $is_active ? 'checked' : ''; ?>>
                <!-- <span class="text-sm">Is Active</span> -->
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
            <button type="submit" class="btn-post-accept-1">Update User</button>
            <a href="./user_management.php" class="btn-post-common-1">Cancel</a>
            <a class="btn-post-danger-1" data-modal-target="default-modal" data-modal-toggle="default-modal">Delete</a>
            <a href="./delete_user.php?id=<?php echo $user_id ?>" class="btn-post-danger-1">Delete</a>
          </form>
        </div>
      </div>
<?php
exit();
}
?>



