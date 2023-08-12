<?php
if (isset($_POST['id'], $_POST['name'], $_POST['code'], $_POST['exchanged'])) {
    // Get the data from the POST request
    $id = $_POST['id'];
    $name = $_POST['name'];
    $code = $_POST['code'];
    $exchanged = $_POST['exchanged'];

    require_once '../database.php';

    // Prepare and execute an UPDATE statement using prepared statements
    $query = "UPDATE gift_codes SET gift_id = ?, code = ?, exchanged = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "sssi", $name, $code, $exchanged, $id);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        $conn->close();
        echo 1; // Success
    } else {
        $conn->close();
        http_response_code(500);
        echo json_encode(array("error" => "Failed to update data."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("error" => "No data found."));
}
?>
