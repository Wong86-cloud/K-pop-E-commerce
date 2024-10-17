<?php
session_start();
include_once('config.php');

// Set the content type to JSON
header('Content-Type: application/json');

// Check database connection
if (!$conn) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (isset($data['product_id'], $data['quantity']) && isset($_SESSION['unique_id'])) {
        $product_id = (int)$data['product_id']; // Cast to int for safety
        $quantity = (int)$data['quantity']; // Cast to int for safety
        $unique_id = $_SESSION['unique_id'];

        // Check if the cart item exists
        $cartCheckQuery = "SELECT * FROM cart WHERE unique_id = ? AND product_id = ?";
        $stmt = $conn->prepare($cartCheckQuery);
        $stmt->bind_param("ii", $unique_id, $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Update the cart quantity
            $updateCartQuery = "UPDATE cart SET quantity = ? WHERE unique_id = ? AND product_id = ?";
            $stmt = $conn->prepare($updateCartQuery);
            $stmt->bind_param("iii", $quantity, $unique_id, $product_id);
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Cart updated successfully']);
            } else {
                error_log("Failed to execute update query: " . $stmt->error); // Log error for debugging
                echo json_encode(['success' => false, 'message' => 'Failed to update cart']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Cart item not found']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
