<?php

// Set the content type to JSON
header('Content-Type: application/json');

require_once '../database.php';

$result = $conn->query('SELECT * FROM memory_images');

// Create an array to hold the memory_images objects
$memory_images = array();

// Loop through the result set
while ($row = $result->fetch_assoc()) {
    // Create a new memory_image object
    $memory_image = array(
        'id' => $row['id'],
        'image' => base64_encode($row['image']),
        'timestamp' => $row['timestamp'],
    );
    $memory_images[] = $memory_image;
}

if (count($memory_images) == 0) {
    http_response_code(400);
    echo json_encode(array("error" => "No data found."));
}

echo json_encode($memory_images);

// Close the database connection
$conn->close();

?>