<?php
session_start();
include_once('../db_connection/config.php');

// Prepare SQL query to fetch best-selling products
$query = "SELECT product_id, product_name, SUM(quantity) AS total_sold
          FROM order_details
          GROUP BY product_id, product_name
          ORDER BY total_sold DESC
          LIMIT 10";  // Adjust the limit as needed

// Execute the query
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result) {
    // Initialize an array to hold the best-selling products
    $bestSellers = [];
    
    // Fetch all rows and add them to the array
    while ($row = mysqli_fetch_assoc($result)) {
        $bestSellers[] = $row;
    }

    // Return the result as JSON
    echo json_encode($bestSellers);
} else {
    // Return an error message if the query fails
    echo json_encode(['error' => 'Query failed: ' . mysqli_error($conn)]);
}

// Close the database connection
mysqli_close($conn);
?>
