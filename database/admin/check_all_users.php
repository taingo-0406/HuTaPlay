<?php

// set the content type to JSON
header('Content-Type: application/json');

require_once '../database.php';

// query the database for all users
$result = $conn->query('SELECT * FROM users');

// create an array to hold the user objects
$users = array();

// loop through the result set
while ($row = $result->fetch_assoc()) {
  // create a new user object
  $user = array(
    'id' => $row['id'],
    'name' => $row['full_name'],
    'email' => $row['email'],
    'points' => $row['points'],
    'stage' => $row['current_stage']
  );
  // add the user object to the users array
  $users[] = $user;
}

if(count($users) == 0){
  http_response_code(400);
  echo json_encode(array("error" => "No data found."));
}

echo json_encode($users);

// close the database connection
$conn->close();

?>
