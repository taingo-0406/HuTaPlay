<?php
require_once 'database.php';

$sql = "SELECT * FROM gifts WHERE display = true";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $gifts[] = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'cost' => $row['cost'],
        );
    }

    echo json_encode($gifts);
} else {
    echo "0 results";
}
$conn->close();
?>