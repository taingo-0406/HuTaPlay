<?php
if (isset($_POST['name'], $_POST['code'], $_POST['exchanged'])) {
    // Get the data from the POST request
    $name = $_POST['name'];
    $code = $_POST['code'];
    $exchanged = $_POST['exchanged'];

    require_once '../database.php';

    // Prepare and execute an INSERT statement using prepared statements
    $query = "INSERT INTO gift_codes (gift_id, code, exchanged) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "iss", $name, $code, $exchanged);

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
