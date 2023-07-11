<?php
session_start();

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['email'])) {
    require_once 'database.php';
    // Retrieve the data from the AJAX request;
    $points = $_POST["points"];
    $stage_id = $_POST["stage_id"];
    $user_email = $_SESSION['email'];
    $user_id = $_SESSION['user_id'];

    // Insert the new record into the play table
    $query = "INSERT INTO play_record (user_id, points, stage_id) VALUES ('$user_id', '$points', '$stage_id')";
    mysqli_query($conn, $query);

    // Update the current_stage of the user
    $query = "UPDATE users SET current_stage = current_stage + 1, points = points + $points WHERE id = '$user_id'";
    mysqli_query($conn, $query);

    // Return a success response
    echo "Play record saved successfully";
}

// Close the database connection
$conn->close();
?>
