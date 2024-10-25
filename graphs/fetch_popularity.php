<?php
session_start();
include_once('../db_connection/config.php');

$sql = "SELECT hashtag, COUNT(*) AS popularity
        FROM rooms
        GROUP BY hashtag
        ORDER BY popularity DESC";

$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Return data as JSON for the front end
header('Content-Type: application/json');
echo json_encode($data);
?>
