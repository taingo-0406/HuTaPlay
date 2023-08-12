<?php

// Check if an id and a file were provided
if (isset($_POST['id'], $_FILES['file'])) {
    // Get the id and file data from the POST request
    $id = $_POST['id'];
    $file = $_FILES['file'];
    $tmp_name = $file['tmp_name'];
    // Read the file data into a variable
    $image_data = file_get_contents($tmp_name);

    require_once '../database.php';

    // Prepare and execute an UPDATE statement using prepared statements
    $query = "UPDATE memory_images SET image = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "bi", $image_data, $id);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        // Close the statement
        mysqli_stmt_close($stmt);

        // Close the database connection
        $conn->close();

        // Set the response code to 200 (OK)
        http_response_code(200);

        // Set the Content-Type header to application/json
        header('Content-Type: application/json');

        // Output an empty JSON object
        echo json_encode(new stdClass);
    } else {
        // Close the statement
        mysqli_stmt_close($stmt);

        // Close the database connection
        $conn->close();

        // Set the response code to 500 (Internal Server Error)
        http_response_code(500);

        // Set the Content-Type header to application/json
        header('Content-Type: application/json');

        // Output an error message as a JSON object
        echo json_encode(array("error" => "Failed to update memory image."));
    }
} else {
    // Set the response code to 400 (Bad Request)
    http_response_code(400);

    // Set the Content-Type header to application/json
    header('Content-Type: application/json');

    // Output an error message as a JSON object
    echo json_encode(array("error" => "No id or file provided."));
}

?>