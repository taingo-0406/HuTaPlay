<?php
session_start();

// Check if the user is logged in (session variable exists)
if (isset($_SESSION['user_id'])) {
    // Retrieve the current stage for the user from the session or database
    $user_id = $_SESSION['user_id'];

    require_once 'database.php';    

    $query = "SELECT exchange_codes_history.code_exchanged, exchange_codes_history.gift_id, gifts.name, gifts.cost FROM exchange_codes_history JOIN gifts ON exchange_codes_history.gift_id = gifts.id WHERE exchange_codes_history.user_id = '$user_id'";

    // Execute the query
    $result = mysqli_query($conn, $query);

    // Check if a row was returned
    if (mysqli_num_rows($result) > 0) {
        while ($row = $result->fetch_assoc()) {
            $codes[] = array(
                'name' => $row['name'],
                'cost' => $row['cost'],
                'code' => $row['code_exchanged'],
            );
        }
        echo json_encode($codes);
    } else {
        // No user found with that email
        http_response_code(400);
        echo json_encode(array("error" => "No result found."));
    }
} else {
    // User is not logged in or session expired
    http_response_code(400);
    echo json_encode(array("error" => "No data found."));
}
?>