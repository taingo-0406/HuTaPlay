<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['email'])) {
    require_once 'database.php';

    $email = $_SESSION['email'];
    $user_id = $_SESSION['user_id'];
    $gift = $_POST['gift'];
    $gift_id = $gift['id'];
    $gift_cost = $gift['cost'];

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Prepare and execute a SELECT statement to get user points
        $stmt = $conn->prepare("SELECT points FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if a row was returned
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $points = $row['points'];

            if ($points >= $gift_cost) {
                // Prepare and execute a SELECT statement to get an available gift code
                $stmt = $conn->prepare("SELECT code FROM gift_codes WHERE exchanged = false AND gift_id = ? LIMIT 1");
                $stmt->bind_param('i', $gift_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows == 1) {
                    $row = $result->fetch_assoc();
                    $code = $row['code'];

                    // Prepare and execute UPDATE statements to update points, mark gift code as exchanged, and insert into exchange history
                    $stmt = $conn->prepare("UPDATE users SET points = points - ? WHERE email = ?");
                    $stmt->bind_param('ds', $gift_cost, $email);
                    $stmt->execute();

                    $stmt = $conn->prepare("UPDATE gift_codes SET exchanged = true WHERE code = ?");
                    $stmt->bind_param('s', $code);
                    $stmt->execute();

                    $stmt = $conn->prepare("INSERT INTO exchange_codes_history (user_id, gift_id, code_exchanged) VALUES (?, ?, ?)");
                    $stmt->bind_param('iis', $user_id, $gift_id, $code);
                    $stmt->execute();

                    // Commit the transaction
                    $conn->commit();

                    echo json_encode(array("success" => true, "code" => $code));
                } else {
                    http_response_code(400);
                    echo json_encode(array("error" => "No gift codes remaining."));
                }
            } else {
                http_response_code(400);
                echo json_encode(array("error" => "You don't have enough points."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("error" => "No user found."));
        }
    } catch (Exception $e) {
        // Rollback the transaction in case of an exception
        $conn->rollback();
        http_response_code(400);
        echo json_encode(array("error" => "Error redeeming gift code."));
    }

    // Close the database connection
    $conn->close();
} else {
    // User is not logged in or session expired
    http_response_code(400);
    echo json_encode(array("error" => "No email found."));
}
?>