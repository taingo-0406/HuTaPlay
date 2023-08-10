<?php

// Check if any files were uploaded
if (isset($_FILES['files'])) {
    // Connect to the database
    require_once '../database.php';

    // Loop through the uploaded files
    foreach ($_FILES['files']['tmp_name'] as $tmp_name) {
        // Read the file data into a variable
        $image_data = file_get_contents($tmp_name);

        // Escape the image data for use in a SQL query
        $image_data = mysqli_real_escape_string($conn, $image_data);

        // Insert the image data into the memory_images table
        $query = "INSERT INTO memory_images (image) VALUES ('$image_data')";
        mysqli_query($conn, $query);
    }

    // Close the database connection
    $conn->close();

    // Set the response code to 200 (OK)
    http_response_code(200);

    // Set the Content-Type header to application/json
    header('Content-Type: application/json');

    // Output an empty JSON object
    echo json_encode(new stdClass);
} else {
    // Set the response code to 400 (Bad Request)
    http_response_code(400);

    // Set the Content-Type header to application/json
    header('Content-Type: application/json');

    // Output an error message as a JSON object
    echo json_encode(array("error" => "No files were uploaded."));
}

?>
