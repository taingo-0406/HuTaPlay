<?php
session_start();

// Check if the request method is POST and a valid session is present
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['email'])) {
    require_once 'database.php';

    $current_stage = $_SESSION['current_stage'];
    $user_id = $_SESSION['user_id'];

    // Get optimal_point from the stage table
    $sql = "SELECT optimal_point FROM stage WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $current_stage);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $optimal_point = $row['optimal_point'];

    // Calculate points and ensure it's not negative
    $points = max($optimal_point - $_POST["points"], 0);

    // Begin a transaction
    mysqli_begin_transaction($conn);

    $stmt1 = null;
    $stmt2 = null;

    try {
        // Insert the new record into the play table
        $query1 = "INSERT INTO play_record (user_id, points, stage_id) VALUES (?, ?, ?)";
        $stmt1 = mysqli_prepare($conn, $query1);
        mysqli_stmt_bind_param($stmt1, "iii", $user_id, $points, $current_stage);
        mysqli_stmt_execute($stmt1);

        // Update the current_stage and points of the user
        $query2 = "UPDATE users SET current_stage = current_stage + 1, points = points + ? WHERE id = ?";
        $stmt2 = mysqli_prepare($conn, $query2);
        mysqli_stmt_bind_param($stmt2, "ii", $points, $user_id);
        mysqli_stmt_execute($stmt2);

        $_SESSION['current_stage'] = $current_stage + 1;

        // Commit the transaction
        mysqli_commit($conn);

        // Return the updated points
        echo $points;
    } catch (Exception $e) {
        // Roll back the transaction on failure
        mysqli_rollback($conn);
        http_response_code(500);
        echo json_encode(array("error" => "Failed to update records."));
    } finally {
        // Close the prepared statements
        if ($stmt1) {
            mysqli_stmt_close($stmt1);
        }
        mysqli_stmt_close($stmt2);
        // Close the database connection
        mysqli_close($conn);
    }
} else {
    // User is not logged in or session expired
    http_response_code(400);
    echo json_encode(array("error" => "No valid session found."));
}
?>