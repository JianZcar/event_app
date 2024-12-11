<?php
include_once "./../../proj_info.php";

// Reatime posting will trigger this
if (isset($_POST['search'])) {
    $input = $_POST['search'];

    $sql_cmd = <<<SQL
        SELECT
            *
        FROM
            users
        WHERE
            username LIKE '$input%';
    SQL;

    $sql_query = $db_conn->query($sql_cmd);
} else {
    $sql_cmd = <<<SQL
        SELECT
            *
        FROM
            users;
    SQL;

    $sql_query = $db_conn->query($sql_cmd);

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Search</title>
</head>
<body>
    <div>

        <!-- Search engine -->
    <div>
        <input type="text" name="search" id="search" value="" placeholder="Search...">
    </div>

    <!-- Search -->
    <div>
    <table>
        <thead>
            <tr>
                <td>ID</td>
                <td>Username</td>
                <td>Is Active</td>
                <td>Remarks</td>
                <td>User Role</td>
                <td>Password</td>
            </tr>
        </thead>
        <tbody>
        <?php if ($sql_query->num_rows > 0):?>
        <?php while ($rows = $sql_query->fetch_assoc()) :?>
            <tr>
                <td><?php echo $rows['id']?></td>
                <td><?php echo $rows['username']?></td>
                <td><?php echo $rows['is_active']?></td>
                <td><?php echo $rows['remarks']?></td>
                <td><?php echo $rows['user_role']?></td>
                <td><?php echo $rows['passwd']?></td>
            </tr>

        <?php endwhile;?>
        <?php endif;?>
        </tbody>
    </table>
    </div>
    </div>
    <script src="./jquery-3.7.1.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#search").keyup(function() {
                var search = $(this).val();
                // alert(search);
                if (search != "") {
                    $.ajax({
                        // how about the only is a single file like this index.php only
                        url: "index.php",
                        method: "POST",
                        data: {search: search},
                        success: function(data) {
                            $("tbody").html(data);
                        }
                    })
                }
            });
        });
    </script>
</body>
</html>