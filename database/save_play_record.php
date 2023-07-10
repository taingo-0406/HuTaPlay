<?php
session_start();

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['email'])) {
    require_once 'database.php';
    // Retrieve the data from the AJAX request;
    $points = $_POST["points"];
    $stage_id = $_POST["stage_id"];
    $user_email = $_SESSION['email'];
    
    // Query the database to check user ID based on email
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $stmt->bind_result($user_id);

    if (!$stmt->fetch()) {
        echo "User not found";
    }
    // Insert the play record into the database
    $sql = "INSERT INTO play_record (user_id, points, stage_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $user_id, $points, $stage_id);
    $stmt->execute();
    $stmt->close();

    // Return a success response
    echo "Play record saved successfully";
}

// Close the database connection
$conn->close();
?>
