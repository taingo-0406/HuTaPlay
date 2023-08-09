<?php

// set the content type to JSON
header('Content-Type: application/json');

require_once '../database.php';

$result = $conn->query('SELECT gift_codes.id, gifts.name AS gift_name, gifts.id AS gift_id ,gift_codes.code, gift_codes.exchanged FROM gift_codes JOIN gifts ON gift_codes.gift_id = gifts.id');

// create an array to hold the user objects
$gifts = array();

// loop through the result set
while ($row = $result->fetch_assoc()) {
    // create a new user object
    $gift = array(
        'id' => $row['id'],
        'gift_id' => $row['gift_id'],
        'gift_name' => $row['gift_name'],
        'code' => $row['code'],
        'exchanged' => $row['exchanged'],
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