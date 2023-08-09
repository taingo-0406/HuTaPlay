<?php

// set the content type to JSON
header('Content-Type: application/json');

require_once '../database.php';

$result = $conn->query('SELECT * FROM gifts');

// create an array to hold the user objects
$gifts = array();

// loop through the result set
while ($row = $result->fetch_assoc()) {
    // create a new user object
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

// close the database connection
$conn->close();

?>