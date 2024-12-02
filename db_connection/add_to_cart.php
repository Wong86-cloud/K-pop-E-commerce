<?php
session_start();
include_once('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $unique_id = $_SESSION['unique_id'];

    // Check if the user is logged in
    if (!isset($unique_id)) {
        echo json_encode(['status' => 'not_logged_in']);
        exit;
    }

    // Fetch product details
    $productQuery = "SELECT product_name, product_image, product_price FROM products WHERE product_id = ?";
    $productStmt = $conn->prepare($productQuery);
    $productStmt->bind_param("i", $product_id);
    $productStmt->execute();
    $productResult = $productStmt->get_result();

    // Check if the product exists
    if ($productResult->num_rows > 0) {
        $product = $productResult->fetch_assoc();
        $product_name = $product['product_name'];
        $product_image = $product['product_image'];
        $product_price = $product['product_price'];

        // Check if the cart already has this product
        $checkCartQuery = "SELECT quantity FROM cart WHERE product_id = ? AND unique_id = ?";
        $stmt = $conn->prepare($checkCartQuery);
        $stmt->bind_param("ii", $product_id, $unique_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Product already in cart, update quantity
            $cartItem = $result->fetch_assoc();
            $newQuantity = $cartItem['quantity'] + $quantity;
            
            // Update the quantity and product details in the cart
            $updateQuery = "UPDATE cart SET quantity = ?, product_name = ?, product_image = ?, product_price = ? WHERE product_id = ? AND unique_id = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("issdii", $newQuantity, $product_name, $product_image, $product_price, $product_id, $unique_id);
            $updateStmt->execute();

            echo json_encode(['status' => 'exists']);
        } else {
            // Add new product to cart
            $insertQuery = "INSERT INTO cart (product_id, unique_id, quantity, product_name, product_image, product_price) VALUES (?, ?, ?, ?, ?, ?)";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bind_param("iiissd", $product_id, $unique_id, $quantity, $product_name, $product_image, $product_price);
            $insertStmt->execute();

            echo json_encode(['status' => 'added']);
        }

        // Close statements
        $productStmt->close();
        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(['status' => 'product_not_found']);
    }
}
?>
