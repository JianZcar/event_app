<?php
global $db_conn;

if (isset($_POST['search_user'])) {
    $username = $_POST['search_user'];

    $sql_cmd = "SELECT * FROM users WHERE username LIKE '%$username%'";
    $result = $db_conn->query($sql_cmd);

    // Get result as an array
    $users = $result->fetch_all(MYSQLI_ASSOC);

    // Output the result
    // echo json_encode($users);
        if(mysqli_num_rows($result) > 0) {
    ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Name</th>
                <th>is_active</th>
                <th>Password</th>
                </table>
                <tbody>
        <?php
            foreach ($users as $user) {
                ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['name']; ?></td>
                    <td><?php echo $user['is_active']; ?></td>
                    <td><?php echo $user['passwd']; ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    <?php
    } else {
        echo "No user found";
    }
}