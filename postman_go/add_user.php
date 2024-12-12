<?php
  include_once './config.php';

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the variables
    $company = $_POST["company"];
    $last_name = $_POST["last_name"];
    $first_name = $_POST["first_name"];
    $email_address = $_POST["email_address"];
    $job_title = $_POST["job_title"];
    $bus_phone = $_POST["business_phone"];
    $home_phone = $_POST["home_phone"];
    $mobile_phone = $_POST["mobile_phone"];
    $fax_number = $_POST["fax_number"];
    $address = $_POST["address"];
    $city = $_POST["city"];
    $state_province = $_POST["state_province"];
    $zip = $_POST["zip_postal_code"];
    $country_region = $_POST["country_region"];
    $web_page = $_POST["webpage"];
    $notes = $_POST["notes"];

    // Prepare the SQL query
    $sql_cmd = "INSERT INTO customers (company, last_name, first_name, email_address, job_title, business_phone, home_phone, mobile_phone, fax_number, address, city, state_province, zip_postal_code, country_region, webpage, notes) VALUES ($company, $last_name, $first_name, $email_address, $job_title, $bus_phone, $home_phone, $mobile_phone, $fax_number, $address, $city, $state_province, $zip, $country_region, $web_page, $notes)";
    $sql_query = $global_conn->query($sql_cmd);

    if ($sql_query) {
      header('Location: ./add_user_success.php');
      exit();
    } else {
      echo "<script>alert('Failed to add user.');</script>";
    }
  }
?>

<head>
  <title>Add User | <?php echo $project_name?></title>
  <link href="./style.css" rel="stylesheet">
</head>

<body>
  <h1>Add User</h1>
  <form action="./add_user.php" method="POST">
    <label for="company">Company:</label>
    <input type="text" name="company" id="company" required>
    <br>
    <label for="last_name">Last Name:</label>
    <input type="text" name="last_name" id="last_name" required>
    <br>
    <label for="first_name">First Name:</label>
    <input type="text" name="first_name" id="first_name" required>
    <br>
    <label for="email_address">Email Address:</label>
    <input type="email" name="email_address" id="email_address" required>
    <br>
    <label for="job_title">Job Title:</label>
    <input type="text" name="job_title" id="job_title" required>
    <br>
    <label for="business_phone">Business Phone:</label>
    <input type="tel" name="business_phone" id="business_phone" required>
    <br>
    <label for="home_phone">Home Phone:</label>
    <input type="tel" name="home_phone" id="home_phone">
    <br>
    <label for="mobile_phone">Mobile Phone:</label>
    <input type="tel" name="mobile_phone" id="mobile_phone">
    <br>
    <label for="fax_number">Fax Number:</label>
    <input type="tel" name="fax_number" id="fax_number">
    <br>
    <label for="address">Address:</label>
    <input type="text" name="address" id="address" required>
    <br>
    <label for="city">City:</label>
    <input type="text" name="city" id="city" required>
    <br>
    <label for="state_province">State/Province:</label>
    <input type="text" name="state_province" id="state_province" required>
    <br>
    <label for="zip_postal_code">Zip/Postal Code:</label>
    <input type="text" name="zip_postal_code" id="zip_postal_code" required>
    <br>
    <label for="country_region">Country/Region:</label>
    <input type="text" name="country_region" id="country_region" required>
    <br>
    <label for="webpage">Web Page:</label>
    <input type="url" name="webpage" id="webpage">
    <br>
    <label for="notes">Notes:</label>
    <textarea name="notes" id="notes"></textarea>
    <br>
    <br>
    <input type="submit" value="Add User">
  </form>
</body>