<?php
if (isset($_POST['id'], $_POST['name'], $_POST['cost'], $_POST['display'])) {
    // get the data from the POST request
    $id = $_POST['id'];
    $name = $_POST['name'];
    $cost = $_POST['cost'];
    $display = $_POST['display'];

    require_once '../database.php';

    // prepare and execute an UPDATE statement
    $query = "UPDATE gifts SET name = '$name', cost = '$cost', display = '$display' WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    $conn->close();

    echo 1;
} else {
    http_response_code(400);
    echo json_encode(array("error" => "No data found."));
}

?>