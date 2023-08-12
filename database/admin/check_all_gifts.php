<?php

// Set the content type to JSON
header('Content-Type: application/json');

require_once '../database.php';

$result = $conn->query('SELECT * FROM gifts');

// Create an array to hold the gift objects
$gifts = array();

// Loop through the result set
while ($row = $result->fetch_assoc()) {
    // Create a new gift object
    $gift = array(
        'id' => $row['id'],
        'name' => $row['name'],
        'cost' => $row['cost'],
        'display' => $row['display'],
    );
    $gifts[] = $gift;
}

if (count($gifts) == 0) {
    http_response_code(400);
    echo json_encode(array("error" => "No data found."));
}

echo json_encode($gifts);

// Close the database connection
$conn->close();

?>
