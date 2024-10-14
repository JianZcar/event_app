
<?php 
// 1. PROJECT INFORMATION

$proj_name = "Event App";       // Project Name (Global and its critial)
$proj_description = "A simple event management application.";


// 2. DATABASE CONNECTION

// Use MySQL Connection
$db_host = "localhost";         // DB Hostname
$db_port = "3306";              // DB Port
$db_user = "root";              // DB Username
$db_pass = "";                  // DB Password
$db_name = "event_app";         // DB Name


$db_conn = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);

// 2.1 Testing connection
if ($db_conn->connect_error) {
  die("Connection failed: " . $db_conn->connect_error -> connect_error);
}


// 3. PROJECT INFORMATION :: DATE

// 3.1 Project founded date
$proj_founded_str = '2024-10-12';
$proj_founded_date = new DateTime($proj_founded_str);

$proj_founded_year = $proj_founded_date->format('Y');
$proj_founded_month = $proj_founded_date->format('m');
$proj_founded_day = $proj_founded_date->format('d');


// Get current year and apply to the html footer.
$proj_current_year = date('Y');

// 4. TESTER SECTION

// 4.1 Tester Information


// 5. CUSTOMIZE SECTION

?>