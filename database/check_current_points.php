<?php
session_start();

// Check if the user is logged in (session variable exists)
if (isset($_SESSION['email'])) {
    // Retrieve the current stage for the user from the session or database
    $email = $_SESSION['email'];

    require_once 'database.php';

    $query = "SELECT points FROM users WHERE email='$email'";
    
    // Execute the query
    $result = mysqli_query($conn, $query);

    // Check if a row was returned
    if (mysqli_num_rows($result) == 1) {
        // Get the row
        $row = mysqli_fetch_assoc($result);

        // Get the points
        $points = $row['points'];

        // Display the points
        echo $points;
    } else {
        // No user found with that email
        echo "No user found with that email";
    }
} else {
    // User is not logged in or session expired
    echo "0";
}
?>