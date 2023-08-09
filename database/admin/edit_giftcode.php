<?php
if (isset($_POST['id'], $_POST['name'], $_POST['code'], $_POST['exchanged'])) {
    // get the data from the POST request
    $id = $_POST['id'];
    $name = $_POST['name'];
    $code = $_POST['code'];
    $exchanged = $_POST['exchanged'];

    require_once '../database.php';

    // prepare and execute an UPDATE statement
    $query = "UPDATE gift_codes SET gift_id = '$name', code = '$code', exchanged = '$exchanged' WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    $conn->close();

    echo 1;
} else {
    http_response_code(400);
    echo json_encode(array("error" => "No data found."));
}

?>