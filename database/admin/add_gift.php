<?php
if (isset($_POST['name'], $_POST['cost'], $_POST['display'])) {
    // Get the data from the POST request
    $name = $_POST['name'];
    $cost = $_POST['cost'];
    $display = $_POST['display'];

    require_once '../database.php';

    // Prepare and execute an INSERT statement using prepared statements
    $query = "INSERT INTO gifts (name, cost, display) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "sdi", $name, $cost, $display);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        $conn->close();
        echo 1; // Success
    } else {
        $conn->close();
        http_response_code(500);
        echo json_encode(array("error" => "Failed to insert data."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("error" => "No data found."));
}
?>
