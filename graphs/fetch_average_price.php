<?php
session_start();
include_once('../db_connection/config.php');

// Set your desired date range
$start_date = '2024-10-01'; // Replace with your actual start date
$end_date = '2024-12-31';   // Replace with your actual end date

// Prepare SQL query to calculate average price
$query = "SELECT AVG(product_price) AS average_price
          FROM order_details
          WHERE order_date BETWEEN '$start_date' AND '$end_date'";

// Execute the query
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result) {
    // Fetch the average price
    $data = mysqli_fetch_assoc($result);
    // Return the result as JSON
    echo json_encode($data);
} else {
    // Return an error message if the query fails
    echo json_encode(['error' => 'Query failed: ' . mysqli_error($conn)]);
}

// Close the database connection
mysqli_close($conn);
?>
