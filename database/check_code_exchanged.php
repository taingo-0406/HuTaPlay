<?php
session_start();

// Check if the user is logged in (session variable exists)
if (isset($_SESSION['user_id'])) {
    // Retrieve the current stage for the user from the session or database
    $user_id = $_SESSION['user_id'];

    require_once 'database.php';    

    $query = "SELECT exchange_codes_history.code_exchanged, exchange_codes_history.gift_id, gifts.name, gifts.cost, exchange_codes_history.timestamp 
              FROM exchange_codes_history 
              JOIN gifts ON exchange_codes_history.gift_id = gifts.id 
              WHERE exchange_codes_history.user_id = ?";

    // Prepare the query
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $user_id);

    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if a row was returned
    if ($result->num_rows > 0) {
        $codes = array();
        while ($row = $result->fetch_assoc()) {
            $codes[] = array(
                'name' => $row['name'],
                'cost' => $row['cost'],
                'code' => $row['code_exchanged'],
                'timestamp' => $row['timestamp']
            );
        }
        echo json_encode($codes);
    } else {
        // No result found
        http_response_code(400);
        echo json_encode(array("error" => "No result found."));
    }

    // Close the prepared statement
    $stmt->close();
} else {
    // User is not logged in or session expired
    http_response_code(400);
    echo json_encode(array("error" => "No data found."));
}

// Close the database connection
$conn->close();
?>
