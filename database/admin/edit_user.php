<?php
if (isset($_POST['email'], $_POST['name'], $_POST['points'], $_POST['stage'])) {
    // Get the data from the POST request
    $email = $_POST['email'];
    $name = $_POST['name'];
    $points = $_POST['points'];
    $stage = $_POST['stage'];

    require_once '../database.php';

    // Prepare and execute an UPDATE statement using prepared statements
    $query = "UPDATE users SET full_name = ?, points = ?, current_stage = ? WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "siis", $name, $points, $stage, $email);

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