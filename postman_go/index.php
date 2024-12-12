<?php
  include_once './config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Users List | <?php echo $project_name?></title>
  <link href="./style.css" rel="stylesheet">
</head>
<body>
  <h1>User Page</h1>
  <!-- <p>This is a basic HTML page.</p> -->
  <a href="./add_user.php">Add data</a>
  <table style="border:1px solid #111;min-width:50vw;max-width:50vw;">
    <tr>
      <th>ID</th>
      <th>Company</th>
      <th>Last Name</th>
      <th>First Name</th>
      <th>Email Address</th>
      <th>Job Title</th>
      <th>Business Phone</th>
      <th>Home Phone</th>
      <th>Mobile Phone</th>
      <th>Fax Number</th>
      <th>Address</th>
      <th>City</th>
      <th>State Province</th>
      <th>ZIP Postal Code</th>
      <th>Country Region</th>
      <th>Webpage</th>
      <th>Notes</th>
      <th colspan="2">Action</th>
    </tr>
    <?php 
    $sql_cmd = "SELECT * FROM customers";
    $sql_query = $global_conn->query($sql_cmd);
  
    if ($sql_query === false) {
      echo "<tr><td colspan='5' style='text-align: center;'>Error: " . $global_conn->error . "</td></tr>";
    } else {
      if ($sql_query->num_rows > 0) {
        $sql_output = $sql_query->fetch_all(MYSQLI_ASSOC);
        for ($i = 0; $i < count($sql_output); $i++) {
          echo "<tr>
                  <td>" . $sql_output[$i]["id"] . "</td>
                  <td>" . $sql_output[$i]["company"] . "</td>
                  <td>" . $sql_output[$i]["last_name"] . "</td>
                  <td>" . $sql_output[$i]["first_name"] . "</td>
                  <td>" . $sql_output[$i]["email_address"] . "</td>
                  <td>" . $sql_output[$i]["job_title"] . "</td>
                  <td>" . $sql_output[$i]["business_phone"] . "</td>
                  <td>" . $sql_output[$i]["home_phone"] . "</td>
                  <td>" . $sql_output[$i]["mobile_phone"] . "</td>
                  <td>" . $sql_output[$i]["fax_number"] . "</td>
                  <td>" . $sql_output[$i]["address"] . "</td>
                  <td>" . $sql_output[$i]["city"] . "</td>
                  <td>" . $sql_output[$i]["state_province"] . "</td>
                  <td>" . $sql_output[$i]["zip_postal_code"] . "</td>  
                  <td>" . $sql_output[$i]["country_region"] . "</td>
                  <td>" . $sql_output[$i]["web_page"] . "</td>
                  <td>" . $sql_output[$i]["notes"] . "</td>
                  <td> <a href='./edit_user.php?id=" . $sql_output[$i]["id"] . "'>Edit</a> </td>
                  <td> <a href='./delete_user.php?id=" . $sql_output[$i]["id"] . "'>Delete</a> </td>
                </tr>";
        }
      } else {
        echo "<tr><td colspan='5' style='text-align: center;'>No record found.</td></tr>";
      }
    }
    ?>
  </table>
</body>
</html>