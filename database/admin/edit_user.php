<?php
if (isset($_POST['email'], $_POST['name'], $_POST['points'], $_POST['stage'])) {
    // get the data from the POST request
    $email = $_POST['email'];
    $name = $_POST['name'];
    $points = $_POST['points'];
    $stage = $_POST['stage'];

    require_once '../database.php';

    // prepare and execute an UPDATE statement
    $query = "UPDATE users SET full_name = '$name', points = '$points', current_stage = '$stage' WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    $conn->close();

    //echo all the data
    echo json_encode(array(
        'email' => $email,
        'name' => $name,
        'points' => $points,
        'stage' => $stage
    ));
} else {
    http_response_code(400);
    echo json_encode(array("error" => "No data found."));
}

?>