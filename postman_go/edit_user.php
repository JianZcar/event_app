<?php
include_once './config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $student_id = $_POST["student_number"];
    $full_name = $_POST["full_name"];
    $gender = $_POST["gender"];

    // Prepare and bind
    $sql_cmd = $global_conn->prepare("UPDATE users_student SET student_number=?, full_name=?, gender=? WHERE id=?");
    $sql_cmd->bind_param("sisi", $student_id, $full_name, $gender, $id);

    // Execute the statement
    if ($sql_cmd->execute()) {
        // Redirect to index.php
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql_cmd->error;
    }

    // Close the statement and connection
    $sql_query->close();
    $global_conn->close();
} else {
    // Fetch user data
    $id = $_GET['id'];
    $sql_query = $global_conn->prepare("SELECT student_number, full_name, gender FROM users_student WHERE id=?");
    $sql_query->bind_param("i", $id);
    $sql_query->execute();
    $result = $sql_query->get_result();
    $user = $result->fetch_assoc();

    // // Close the statement
    // $sql_query->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>
    <h1>Edit User</h1>
    <form action="./edit_user.php" method="POST">
        <!-- <input type="hidden" name="id" value="<?php echo $user['id']; ?>"> -->
        <label for="student_number">Student Number:</label>
        <input type="number" name="student_number" id="student_number" value="<?php echo $user['student_number']; ?>" required>
        <br>
        <label for="full_name">Full Name:</label>
        <input type="text" name="full_name" id="full_name" value="<?php echo $user['full_name']; ?>" required>
        <br>
        <label for="gender">Gender:</label>
        <input type="number" name="gender" id="gender" value="<?php echo $user['gender']; ?>" required>
        <br>
        <input type="submit" value="Update User">
    </form>
</body>
</html>