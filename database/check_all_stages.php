<?php
require_once 'database.php';

// SQL query to count the number of stages in the stage table
$sql = "SELECT COUNT(*) as stage_count FROM stage";
$result = $conn->query($sql);

// Check if the query returned any results
if ($result->num_rows > 0) {
    // Fetch the first row of the result set
    $row = $result->fetch_assoc();

    // Get the stage count from the row
    $stage_count = $row["stage_count"];

    // Output the stage count
    echo $stage_count;
} else {
    http_response_code(400);
    echo json_encode(array("error" => "No data found."));
}

// Close the database connection
$conn->close();
?>