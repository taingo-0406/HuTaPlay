<?php
if (isset($_POST['id'], $_POST['toh_discs'], $_POST['memory_size'], $_POST['optimal_points'])) {
    // Get the data from the POST request
    $id = $_POST['id'];
    $toh_discs = $_POST['toh_discs'];
    $memory_size = $_POST['memory_size'];
    $optimal_points = $_POST['optimal_points'];

    require_once '../database.php';

    // Prepare and execute an UPDATE statement using prepared statements
    $query = "UPDATE stage SET toh_disk = ?, memory_size = ?, optimal_point = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "iiii", $toh_discs, $memory_size, $optimal_points, $id);

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