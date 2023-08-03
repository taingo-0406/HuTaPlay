<?php
session_start();

// Check if the user is logged in (session variable exists)
if (isset($_SESSION['email'])) {
    // Retrieve the current stage for the user from the session or database
    $currentStage = $_SESSION['current_stage'];

    require_once 'database.php';
    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT toh_disk, memory_size FROM stage WHERE id = ?");
    $stmt->bind_param("i", $currentStage);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $memory_size = $row['memory_size'];
        $tohDisk = $row['toh_disk'];
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();

    $stageInfo = array(
        'current_stage' => $currentStage,
        'toh_disk' => $tohDisk,
        'memory_size' => $memory_size,
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