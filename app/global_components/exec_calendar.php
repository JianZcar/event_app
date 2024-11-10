<?php
require './../../proj_info.php';

global $db_conn;
$sql_events = <<<SQL
SELECT 
  id,
  subject_name,
  content,
  start_datetime,
  end_datetime
FROM 
  event_posts;
SQL;

$result_events = $db_conn->query($sql_events);

// Convert events to array
$result_events = $result_events->fetch_all(MYSQLI_ASSOC);

// Convert datetime to ISO8601 format
foreach ($result_events as $key => $event) {
  $result_events[$key]['start_datetime'] = date('c', strtotime($event['start_datetime']));
  $result_events[$key]['end_datetime'] = date('c', strtotime($event['end_datetime']));
}

// Prepare data for JSON response
if (count($result_events) > 0) {
  $data = array(
    'status' => true,
    'msg' => 'successfully!',
    'data' => $result_events
  );
} else {
  $data = array(
    'status' => false,
    'msg' => 'Error!'
  );
}

echo json_encode($data);
?>