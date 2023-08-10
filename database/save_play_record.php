<?php
session_start();

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['email'])) {
    require_once 'database.php';

    $current_stage = $_SESSION['current_stage'];

    $sql = "SELECT optimal_point FROM stage WHERE id = $current_stage";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $optimal_point = $row['optimal_point'];
    // Retrieve the data from the AJAX request;
    $points = $optimal_point - $_POST["points"];
    if($points < 0){
        $points = 0;
    }
    $stage_id = $_POST["stage_id"];
    $user_email = $_SESSION['email'];
    $user_id = $_SESSION['user_id'];

    // Insert the new record into the play table
    $query1 = "INSERT INTO play_record (user_id, points, stage_id) VALUES ('$user_id', '$points', '$current_stage')";
    mysqli_query($conn, $query1);

    // Update the current_stage of the user
    $query2 = "UPDATE users SET current_stage = current_stage + 1, points = points + $points WHERE id = '$user_id'";
    mysqli_query($conn, $query2);

    $_SESSION['current_stage'] = $current_stage + 1;
    // Return a success response
    //echo user id, points, stage id
    echo $points;
}

// Close the database connection
$conn->close();
?>
