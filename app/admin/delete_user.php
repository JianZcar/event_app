<?php
session_start();
include "./../../proj_info.php";
$page_name = "Admin Panel";
$page_full_name = "$page_name | $proj_name";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Prepare the delete query
    $sql_cmd = $db_conn->prepare("DELETE FROM users WHERE id = ?");
    $sql_cmd->bind_param("i", $user_id);

    if ($sql_cmd->execute()) {
      $_SESSION['msg_account_announce'] = "User deleted successfully.";
    } else {
      $_SESSION['msg_account_announce'] = "Error deleting user.";
    }

    // Redirect to a confirmation or list page
    header("Location: user_managment.php");
  } else {
    $_SESSION['msg_account_announce'] = "User ID not provided.";
    header("Location: user_managment.php");
  }
} else {
  if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $edit_mode = TRUE;

    // Prepare the query
    $sql_cmd = <<<SQL
    SELECT * FROM users WHERE id = $user_id;
    SQL;

    $result = $db_conn->query($sql_cmd);

    // Only one id should be returned
    if ($result->num_rows == 1) {
      $row = $result->fetch_assoc();
      $username = $row['username'];
      $is_active = $row['is_active'];
      $role = $row['user_role'];
    } else {
      $_SESSION['msg_account_announce'] = "User ID not found.";
      header("Location: user_management.php");
    }
  } else {
    $_SESSION['msg_account_announce'] = "User ID not provided.";
    header("Location: user_management.php");
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $page_full_name?></title>
  <link href="../global_assets/css/output.css" rel="stylesheet">
  <link href="./../global_assets/css/global_footer.css" rel="stylesheet">
  <!-- <link href="./../global_assets/css/panel.css" rel="stylesheet"> -->
  <!-- <link href="./../global_assets/css/sidebar.css" rel="stylesheet"> -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body class="flex flex-row min-w-screen h-screen">

<!-- Left Sidebar -->
<div class="slide-panel" id="sidebar-content">
  <?php include './../global_components/sidebar.php';?>
</div>

<!-- Rest is main content -->
  <!-- Main Content -->
  <div class="flex flex-col w-screen max-w-screen min-h-screen">
    <!-- Header -->
    <header class="flex flex-row bg-blue-500 text-white p-1 btn-slide">
      <a class="p-2 text-2xl hover-action" id="btn-menu-list" onclick="slideOpen()"><i class='bx bx-menu'></i></a>
      <h1 class="p-2 text-2xl"><?php echo $page_full_name?></h1>
    </header>

    <!-- Main Object -->
    <main class="flex flex-col w-full h-full m-h-screen">

        <div class="p-base">
            <h1 class="p-title" >Welcome back, Administrator!</h1>
        </div>

        <div class="p-base">
          <p>Do you want to delete <?php echo $username?>?</p>
        </div>


        <div class="p-base">
        <button 
            id="open-dialog-btn"
            data-dialog-target="sign-in-dialog"
            onclick="modal_DeleteAccount('<?php echo $username; ?>');"
            class="rounded-md bg-slate-800 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-slate-700 focus:shadow-none active:bg-slate-700 hover:bg-slate-700 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none ml-2" type="button">
            Open Dialog
        </button>

        <!-- <div
            id="modal-delete-account"
            data-dialog-backdrop="sign-in-dialog"
            data-dialog-backdrop-close="true"
            class="fixed inset-0 z-[999] grid h-screen w-screen place-items-center bg-black bg-opacity-60 opacity-0 backdrop-blur-sm transition-opacity duration-300 pointer-events-none opacity-0"
        >
            <div
                id="sign-in-dialog"
                data-dialog="sign-in-dialog"
                class="relative mx-auto w-full max-w-[24rem] rounded-lg overflow-hidden shadow-sm">
                <div class="relative flex flex-col bg-white">
                  
                    <div class="modal-panel-1 bg-red-700 text-white">
                        <h3 class="text-4xl">
                          <i class='bx bx-trash'></i>
                        </h3>
                    </div>
                    <div class="modal-panel-1 h-5">
                    Do you want to delete <?php echo $username?>?
                    </div>
                    
                    <div class="p-6 pt-0">
                        <button class="btn-post-danger-1" type="button">Delete</button>
                        <button id="close-dialog-btn" class="btn-post-common-1" type="button">Cancel</button>
                    </div>
                </div>
            </div>
        </div> -->

    </main>
    <script src="./../global_assets/js/modal.js"></script>
    <!-- <script>
      let modal_btn_close = document.querySelector('#open-dialog-btn');
      let modal_btn_open = document.querySelector('#close-dialog-btn');
      let modal_dialog = document.querySelector('#modal-delete-account');

      // console.log(modal_btn); // Check if the button is selected
      // console.log(modal_dialog); // Check if the modal dialog is selected

      modal_btn_open.addEventListener('click', function() {
          modal_dialog.classList.toggle('pointer-events-none');
          modal_dialog.classList.toggle('opacity-0');
      });

      modal_btn_close.addEventListener('click', function() {
          modal_dialog.classList.toggle('pointer-events-none');
          modal_dialog.classList.toggle('opacity-0');
      });
    </script> -->

    <!-- Footer -->
    <footer class="bg-gray-800 text-white p-4 p-footer" id="p-footer">
      <p>All rights reserved <?php echo $proj_current_year?></p>
    </footer>

    <script src="./../global_assets/js/sidebar.js"></script>
  </div>

</body>
</html>