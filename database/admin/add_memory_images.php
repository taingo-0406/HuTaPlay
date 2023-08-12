<?php

// Check if any files were uploaded
if (isset($_FILES['files'])) {
    // Connect to the database
    require_once '../database.php';

    // Prepare and execute an INSERT statement using prepared statements
    $query = "INSERT INTO memory_images (image) VALUES (?)";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        // Bind the image data parameter
        mysqli_stmt_bind_param($stmt, "s", $image_data);

        // Loop through the uploaded files
        foreach ($_FILES['files']['tmp_name'] as $tmp_name) {
            // Read the file data into a variable
            $image_data = file_get_contents($tmp_name);

            // Execute the statement
            mysqli_stmt_execute($stmt);
        }

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
        // Set the response code to 500 (Internal Server Error)
        http_response_code(500);

        // Set the Content-Type header to application/json
        header('Content-Type: application/json');

        // Output an error message as a JSON object
        echo json_encode(array("error" => "Failed to prepare statement."));
    }
} else {
    // Set the response code to 400 (Bad Request)
    http_response_code(400);

    // Set the Content-Type header to application/json
    header('Content-Type: application/json');

    // Output an error message as a JSON object
    echo json_encode(array("error" => "No files were uploaded."));
}

?>
