<?php

// Set the content type to JSON
header('Content-Type: application/json');

require_once '../database.php';

// Prepare and execute a SELECT statement using prepared statements
$query = 'SELECT gift_codes.id, gifts.name AS gift_name, gifts.id AS gift_id, gift_codes.code, gift_codes.exchanged, gift_codes.timestamp as timestamp 
          FROM gift_codes 
          JOIN gifts ON gift_codes.gift_id = gifts.id 
          LEFT JOIN exchange_codes_history ON gift_codes.code = exchange_codes_history.code_exchanged';
$stmt = $conn->prepare($query);

if ($stmt) {
    // Execute the statement
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    // Create an array to hold the gift objects
    $gifts = array();

    // Loop through the result set
    while ($row = $result->fetch_assoc()) {
        // Create a new gift object
        $gift = array(
            'id' => $row['id'],
            'gift_id' => $row['gift_id'],
            'gift_name' => $row['gift_name'],
            'code' => $row['code'],
            'exchanged' => $row['exchanged'],
            'timestamp' => $row['timestamp']
        );
        $gifts[] = $gift;
    }

    if (count($gifts) == 0) {
        http_response_code(400);
        echo json_encode(array("error" => "No data found."));
    }

    echo json_encode($gifts);

    // Close the statement
    $stmt->close();
} else {
    http_response_code(500);
    echo json_encode(array("error" => "Failed to prepare statement."));
}

// Close the database connection
$conn->close();

?>
