<?php
session_start();
include_once('../db_connection/config.php');

// SQL query to get best-selling products by celebrity
$sql = "SELECT p.celebrity, SUM(od.quantity) AS total_sold
        FROM order_details od
        JOIN products p ON od.product_id = p.product_id
        GROUP BY p.celebrity
        ORDER BY total_sold DESC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $bestSellingCelebrities = [];
    while ($row = $result->fetch_assoc()) {
        $bestSellingCelebrities[] = [
            'celebrity' => $row['celebrity'],
            'total_sold' => $row['total_sold']
        ];
    }
    echo json_encode($bestSellingCelebrities);
} else {
    echo json_encode([]);
}

$conn->close();
?>
