<?php

if (isset($_GET["stage"])) {
    $stage = intval($_GET["stage"]);
} else {
    http_response_code(400);
    echo json_encode(array("error" => "No stage found."));
}

require_once 'database.php';

// SQL query to retrieve data from play_record table
$sql = "SELECT users.full_name, MAX(play_record.points) as points FROM play_record JOIN users ON play_record.user_id = users.id WHERE play_record.stage_id = $stage GROUP BY play_record.user_id ORDER BY points DESC";
$result = $conn->query($sql);

// Create an array to store the results
$results_array = array();

if (mysqli_num_rows($result) > 0) {
    // Output data of each        
    while ($row = $result->fetch_assoc()) {
        // Add the row to the results array
        $results_array[] = $row;
    }
} else {
    http_response_code(400);
    echo json_encode(array("error" => "No data found."));
}

// Close the database connection
$conn->close();

// Encode the results array as a JSON object and return it
echo json_encode($results_array);
?>