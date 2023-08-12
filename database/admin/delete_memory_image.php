<?php

// Check if an id was provided
if (isset($_POST['id'])) {
    // Get the id from the POST request
    $id = $_POST['id'];

    // Connect to the database
    require_once '../database.php';

    // Prepare and execute a DELETE statement
    $stmt = $conn->prepare("DELETE FROM memory_images WHERE id = ?");
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        // Close the statement
        $stmt->close();

        // Close the database connection
        $conn->close();

        // Set the response code to 200 (OK)
        http_response_code(200);

        // Set the Content-Type header to application/json
        header('Content-Type: application/json');

        // Output an empty JSON object
        echo json_encode(new stdClass);
    } else {
        // Set the response code to 500 (Internal Server Error)
        http_response_code(500);

        // Set the Content-Type header to application/json
        header('Content-Type: application/json');

        // Output an error message as a JSON object
        echo json_encode(array("error" => "Failed to delete memory image."));
    }
} else {
    // Set the response code to 400 (Bad Request)
    http_response_code(400);

    // Set the Content-Type header to application/json
    header('Content-Type: application/json');

    // Output an error message as a JSON object
    echo json_encode(array("error" => "No id provided."));
}

?>