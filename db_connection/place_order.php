<?php
session_start();
include_once('config.php'); // Include your database connection

$unique_id = $_SESSION['unique_id'];

// Fetch user data from the database
$user_query = "SELECT handphone FROM users WHERE unique_id = ?";
$user_stmt = $conn->prepare($user_query);
$user_stmt->bind_param('s', $unique_id);
$user_stmt->execute();
$user_result = $user_stmt->get_result();

if ($user_result->num_rows > 0) {
    $user_data = $user_result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $postcode = $_POST['postcode'];
    $city = $_POST['city'];
    $country_code = $_POST['country_code'];
    $handphone = $user_data['handphone'];
    $order_cost = $_POST['order_cost'];
    $shipping_id = $_POST['shipping_id']; // Selected shipping method

    // Debugging output for shipping_id
echo "Shipping ID: " . htmlspecialchars($shipping_id); // Check the value

// Ensure the shipping_id is valid
$check_shipping_id_query = "SELECT * FROM shipping_methods WHERE shipping_id = ?";
$check_shipping_id_stmt = $conn->prepare($check_shipping_id_query);
$check_shipping_id_stmt->bind_param('i', $shipping_id);
$check_shipping_id_stmt->execute();
$check_shipping_result = $check_shipping_id_stmt->get_result();

if ($check_shipping_result->num_rows === 0) {
    echo "Invalid shipping ID. Please select a valid shipping method.";
    exit();
}

// Insert order into the orders table
$query = "INSERT INTO orders (order_cost, shipping_id, unique_id, country_code, handphone, address, postcode, city, order_status, order_date)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Pending', NOW())";
$stmt = $conn->prepare($query);
$stmt->bind_param('dissssss', $order_cost, $shipping_id, $unique_id, $country_code, $handphone, $address, $postcode, $city);

    // Insert order details into the orders table
    if ($stmt->execute()) {
        // Get the last inserted order ID
        $order_id = $stmt->insert_id;

        // Insert order details into order_details table
        $cart_query = "SELECT * FROM cart WHERE unique_id = ?";
        $cart_stmt = $conn->prepare($cart_query);
        $cart_stmt->bind_param('s', $unique_id);
        $cart_stmt->execute();
        $cart_result = $cart_stmt->get_result();

        while ($cart_row = $cart_result->fetch_assoc()) {
            $product_id = $cart_row['product_id'];
            $product_image = $cart_row['product_image'];
            $product_name = $cart_row['product_name'];
            $quantity = $cart_row['quantity'];
            $product_price = $cart_row['product_price'];
        
            // Make sure unique_id is defined before using it
            $unique_id = $_SESSION['unique_id']; // Assuming this is where unique_id is stored
        
            // Prepare the INSERT query
            $order_detail_query = "INSERT INTO order_details (order_id, unique_id, product_id, product_image, product_name, quantity, product_price) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $order_detail_stmt = $conn->prepare($order_detail_query);
            
            // Bind the parameters - ensure correct data types
            $order_detail_stmt->bind_param('iiissid', $order_id, $unique_id, $product_id, $product_image, $product_name, $quantity, $product_price);
            
            // Execute the statement
            if ($order_detail_stmt->execute()) {
                // Optionally, you can check for success here
            } else {
                // Handle any errors
                echo "Error: " . $order_detail_stmt->error;
            }
        }        

        // Clear the cart after order placement (optional)
        $clear_cart_query = "DELETE FROM cart WHERE unique_id = ?";
        $clear_cart_stmt = $conn->prepare($clear_cart_query);
        $clear_cart_stmt->bind_param('s', $unique_id);
        $clear_cart_stmt->execute();

        // Redirect to order.php with the order ID
        header("Location: ../order.php?order_id=" . $order_id);
        exit();
    } else {
        echo "Error: " . $stmt->error; // Show specific error
    }
}
?>
