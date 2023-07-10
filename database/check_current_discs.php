<?php
session_start();

// Check if the user is logged in (session variable exists)
if (isset($_SESSION['email'])) {
    // Retrieve the current stage for the user from the session or database
    $currentStage = $_SESSION['current_stage'];

    require_once 'database.php';

    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT toh_disk FROM stage WHERE id = ?");
    $stmt->bind_param("i", $currentStage);
    $stmt->execute();
    $stmt->bind_result($tohDisk);
    $stmt->fetch();

    // Close the statement and database connection
    $stmt->close();
    $conn->close();

    $stageInfo = array (
        'toh_disk' => $tohDisk,
        'current_stage' => $currentStage
    );
    // Convert the array to JSON
    $jsonData = json_encode($stageInfo);

    // Echo the JSON data
    echo $jsonData;
} else {
    // User is not logged in or session expired
    echo "0";
}
?>
