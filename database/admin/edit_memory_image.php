<?php

// Check if an id and a file were provided
if (isset($_POST['id'], $_FILES['file'])) {
    // Get the id and file data from the POST request
    $id = $_POST['id'];
    $file = $_FILES['file'];
    $tmp_name = $file['tmp_name'];
    // Read the file data into a variable
    $image_data = file_get_contents($tmp_name);

    // Connect to the database
    require_once '../database.php';

    // Escape the image data for use in a SQL query
    $image_data = mysqli_real_escape_string($conn, $image_data);

    // Prepare and execute an UPDATE statement
    $query = "UPDATE memory_images SET image = '$image_data' WHERE id = '$id'";
    mysqli_query($conn, $query);

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
    echo json_encode(array("error" => "No id or file provided."));
}

?>
