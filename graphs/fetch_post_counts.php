<?php
session_start();
include_once('../db_connection/config.php');

// Query to get post count per room
$sql = "SELECT r.room_name AS room, COUNT(p.post_id) AS post_count
FROM rooms r
JOIN posts p ON r.room_id = p.room_id
GROUP BY r.room_id
ORDER BY post_count DESC
LIMIT 10"; // Adjust limit as needed for top results

$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
while ($row = $result->fetch_assoc()) {
$data[] = $row;
}
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($data);

?>
