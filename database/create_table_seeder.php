<?php

// Generate current timestamp
$currentTimestamp = date('Y-m-d H:i:s');

// Table creation SQL statements
$tables = [
    "users" => "
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            full_name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL,
            points INT DEFAULT 0,
            current_stage INT DEFAULT 1,
            role VARCHAR(255) DEFAULT 'user',
            timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ",
    "stage" => "
        CREATE TABLE IF NOT EXISTS stage (
            id INT AUTO_INCREMENT PRIMARY KEY,
            toh_disk INT DEFAULT 0,
            memory_size INT DEFAULT 0,
            optimal_point INT DEFAULT 0,            
        )
    ",
    "play_record" => "
        CREATE TABLE IF NOT EXISTS play_record (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            points INT DEFAULT 0,
            stage_id INT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id),
            FOREIGN KEY (stage_id) REFERENCES stage(id)
        )
    ",
    "gifts" => "
        CREATE TABLE IF NOT EXISTS gifts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255),
            cost INT DEFAULT 0,
            display BOOLEAN,
            timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ",
    "gift_codes" => "
        CREATE TABLE IF NOT EXISTS gift_codes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            gift_id INT,
            code VARCHAR(255),
            exchanged BOOLEAN,
            timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (gift_id) REFERENCES gifts(id)
        )
    ",
    "exchange_codes_history" => "
        CREATE TABLE IF NOT EXISTS exchange_codes_history (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            gift_id INT,
            timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id),
            FOREIGN KEY (gift_id) REFERENCES gifts(id)
        )
    "
];

require_once 'database.php';

// Create tables
foreach ($tables as $tableName => $createStatement) {
    if ($conn->query("SHOW TABLES LIKE '$tableName'")->num_rows === 0) {
        if ($conn->query($createStatement) === TRUE) {
            echo "Table $tableName created successfully.<br>";
        } else {
            echo "Error creating table $tableName<br>";
        }
    } else {
        echo "Table $tableName already exists.<br>";
    }
}

// Users and admin data
$usersData = [
    ["User 1", "user1@users.com", password_hash("users1", PASSWORD_DEFAULT), 0, 1, "user"],
    ["User 2", "user2@users.com", password_hash("users2", PASSWORD_DEFAULT), 0, 1, "user"],
    ["User 3", "user3@users.com", password_hash("users3", PASSWORD_DEFAULT), 0, 1, "user"],
    ["Admin", "admin@admin.com", password_hash("admin", PASSWORD_DEFAULT), 0, 1, "admin"]
];

// Insert users and admin data
foreach ($usersData as $userData) {
    $sql = "INSERT INTO users (full_name, email, password, points, current_stage, role, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssiis", ...$userData);
    $stmt->execute();
}

// Close connection
$conn->close();

?>