
<?php 
// Project Information
$proj_name = "Event App";


// Date Information for this project information
$proj_founded_str = '2024-10-12';
$proj_founded_date = new DateTime($proj_founded_str);

// Filtering process for getting the year, month, and day
// for how long the project has been founded.
$proj_founded_year = $proj_founded_date->format('Y');
$proj_founded_month = $proj_founded_date->format('m');
$proj_founded_day = $proj_founded_date->format('d');



// Realtime information for this project information

// Get current year
$proj_current_year = date('Y');


?>