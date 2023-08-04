<?php
session_start();

if (isset($_SESSION['email'])) {
    // Retrieve the current stage for the user from the session or database
    $email = $_SESSION['email'];
    $gift = $_POST['gift'];
    $gift_id = $gift['id'];
    $gift_cost = $gift['cost'];

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

        if ($points >= $gift_cost) {
            // Check if there are any remaining gift codes
            $query = "SELECT code FROM gift_codes WHERE exchanged = false AND gift_id = $gift_id LIMIT 1";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                $code = $row['code'];
                $query1 = "UPDATE users SET points = points - $gift_cost WHERE email = '$email'";
                $query2 = "UPDATE gift_codes SET exchanged = true WHERE code = $code";
                $result1 = mysqli_query($conn, $query1);
                $result2 = mysqli_query($conn, $query2);
                if ($result1 && $result2) {
                    echo json_encode(array("success" => true, "code" => $code));
                } else {
                    http_response_code(400);
                    echo "Error updating record: " . mysqli_error($conn);
                }
            } else {
                http_response_code(400);
                echo "No gift codes remaining.";
            }
        } else {
            http_response_code(400);
            echo "You don't have enough points.";
        }
    } else {
        // User is not logged in or session expired
        http_response_code(400);
        echo json_encode(array("error" => "No user found."));
    }
} else {
    // User is not logged in or session expired
    http_response_code(400);
    echo json_encode(array("error" => "No email found."));
}
?>