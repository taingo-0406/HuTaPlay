<?php

// set the content type to JSON
header('Content-Type: application/json');

require_once '../database.php';

// query the database for all stages
$result = $conn->query('SELECT * FROM stage');

// create an array to hold the user objects
$stages = array();

// loop through the result set
while ($row = $result->fetch_assoc()) {
    // create a new user object
    $stage = array(
        'id' => $row['id'],
        'toh_disk' => $row['toh_disk'],
        'memory_size' => $row['memory_size'],
        'optimal_point' => $row['optimal_point'],
    );
    // add the user object to the stages array
    $stages[] = $stage;
}

if (count($stages) == 0) {
    http_response_code(400);
    echo json_encode(array("error" => "No data found."));
}

echo json_encode($stages);

// close the database connection
$conn->close();

?>