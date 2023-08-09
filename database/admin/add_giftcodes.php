<?php
if (isset($_POST['name'], $_POST['code'], $_POST['exchanged'])) {
    // get the data from the POST request
    $name = $_POST['name'];
    $code = $_POST['code'];
    $exchanged = $_POST['exchanged'];

    require_once '../database.php';

    // prepare and execute an UPDATE statement
    $query = "INSERT INTO gift_codes (gift_id, code, exchanged) VALUES ('$name', '$code', '$exchanged')";
    $result = mysqli_query($conn, $query);

    $conn->close();

    echo 1;
} else {
    http_response_code(400);
    echo json_encode(array("error" => "No data found."));
}

?>