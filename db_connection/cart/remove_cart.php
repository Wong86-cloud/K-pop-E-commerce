<?php
session_start();
$conn = mysqli_connect("127.0.0.1", "root", "", "kpop_e-commerce");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Set the content type to JSON
header('Content-Type: application/json');

// Check database connection
if (!$conn) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['product_id']) && isset($_SESSION['unique_id'])) {
        $product_id = $data['product_id'];
        $unique_id = $_SESSION['unique_id'];

        error_log("Product ID: " . $product_id);
        error_log("Unique ID: " . $unique_id);

        // Delete the product from the cart
        $deleteQuery = "DELETE FROM cart WHERE unique_id = ? AND product_id = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("ii", $unique_id, $product_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Item removed from cart']);
        } else {
            error_log("Failed to execute query: " . $stmt->error);
            echo json_encode(['success' => false, 'message' => 'Failed to remove item: ' . $stmt->error]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
