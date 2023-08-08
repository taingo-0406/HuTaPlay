<?php
if (isset($_POST['toh_discs'], $_POST['memory_size'], $_POST['optimal_points'])) {
    // get the data from the POST request
    $toh_discs = $_POST['toh_discs'];
    $memory_size = $_POST['memory_size'];
    $optimal_points = $_POST['optimal_points'];

    require_once '../database.php';

    // prepare and execute an UPDATE statement
    $query = "INSERT INTO stage (toh_disk, memory_size, optimal_point) VALUES ('$toh_discs', '$memory_size', '$optimal_points')";
    $result = mysqli_query($conn, $query);

    $conn->close();

    echo 1;
} else {
    http_response_code(400);
    echo json_encode(array("error" => "No data found."));
}

?>