
<?php 
// 1. PROJECT INFORMATION

global $proj_name, $proj_version, $proj_description, $proj_author;
$proj_name = "Event App";       // Project Name (Global and its critial)
$proj_version = "1.0.0";        // Project Version
$proj_description = "A simple event management application.";
$proj_author = "aceday, JianZCar, JovTim";      // Project Author

// 2. DATABASE CONNECTION

// Use MySQL Connection
$db_toggle = TRUE;

if ($db_toggle) {
  $db_host = "localhost";         // DB Hostname
  $db_port = "3306";              // DB Port
  $db_user = "root";              // DB Username
  $db_pass = "Day15@!";           // DB Password
  $db_name = "event_app";         // DB Name

  global $db_conn;
  $db_conn = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);

  // 2.1 Testing connection
  try {
    if ($db_conn->connect_error) {
      throw new mysqli_sql_exception($db_conn->connect_error);
    }
  } catch (mysqli_sql_exception $e) {
    echo "Connection failed: " . $e->getMessage();
  }
}



// 3. PROJECT INFORMATION :: DATE

// 3.1 Project founded date
$proj_founded_str = '2024-10-12';
$proj_founded_date = new DateTime($proj_founded_str);

$proj_founded_year = $proj_founded_date->format('Y');
$proj_founded_month = $proj_founded_date->format('m');
$proj_founded_day = $proj_founded_date->format('d');


// Get current year and apply to the html footer.
global $proj_current_year;
$proj_current_year = date('Y');

// 4. TESTER SECTION
// 4.1 Tester Information

// Email Setup
$senderEmail = "test";
$senderPWD = "test";
// 5. CUSTOMIZE SECTION

?>