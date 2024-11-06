<?php
session_start();
include_once('../db_connection/config.php');

$sql = "SELECT u.country AS country,
               COUNT(o.order_id) AS total_purchases
        FROM orders o
        JOIN users u ON o.unique_id = u.unique_id
        GROUP BY u.country
        ORDER BY total_purchases DESC";

$result = $conn->query($sql);

$data = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    die("Query error: " . $conn->error);
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($data);
exit;
?>
