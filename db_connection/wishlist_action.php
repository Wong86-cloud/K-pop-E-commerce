<?php
session_start();
include_once('config.php'); // Include your database connection

// Get the raw POST data
$data = json_decode(file_get_contents("php://input"), true);

$product_id = $data['product_id'];
$action = $data['action'];

// Assuming unique_id is stored in session
$unique_id = $_SESSION['unique_id'];

if ($action === 'add') {
    // Add item to wishlist
    $query = "INSERT INTO wishlist (unique_id, product_id) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $unique_id, $product_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add to wishlist.']);
    }
} elseif ($action === 'remove') {
    // Remove item from wishlist
    $query = "DELETE FROM wishlist WHERE unique_id = ? AND product_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $unique_id, $product_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to remove from wishlist.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid action.']);
}

$stmt->close();
$conn->close();
?>

