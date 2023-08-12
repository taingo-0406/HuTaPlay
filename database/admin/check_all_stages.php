<?php

// Set the content type to JSON
header('Content-Type: application/json');

require_once '../database.php';

// Query the database for all stages
$result = $conn->query('SELECT * FROM stage');

// Create an array to hold the stage objects
$stages = array();

// Loop through the result set
while ($row = $result->fetch_assoc()) {
    // Create a new stage object
    $stage = array(
        'id' => $row['id'],
        'toh_disk' => $row['toh_disk'],
        'memory_size' => $row['memory_size'],
        'optimal_point' => $row['optimal_point'],
    );
    // Add the stage object to the stages array
    $stages[] = $stage;
}

if (count($stages) == 0) {
    http_response_code(400);
    echo json_encode(array("error" => "No data found."));
}

echo json_encode($stages);

// Close the database connection
$conn->close();

?>