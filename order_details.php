<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <link rel="stylesheet" href="assets/css/bar.css">
    <link rel="stylesheet" href="assets/css/order_details.css">
</head>
<body>

<?php 
include_once('navigation/header.php'); 
include_once('navigation/sidebar.php'); 

// Get the order ID from the URL
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : null;
$unique_id = $_SESSION['unique_id']; // Fetch unique_id from the session

if (!$order_id) {
    echo "Invalid order ID.";
    exit();
}

// Fetch order details
$order_query = "
    SELECT od.product_id, od.product_image, od.product_name, od.quantity, od.product_price, 
           o.order_date, o.order_status, o.order_cost, s.shipping_name, s.shipping_fee
    FROM order_details od
    JOIN orders o ON od.order_id = o.order_id
    JOIN shipping_methods s ON o.shipping_id = s.shipping_id
    WHERE od.order_id = ? AND od.unique_id = ?
";

$order_stmt = $conn->prepare($order_query);
$order_stmt->bind_param('ii', $order_id, $unique_id);
$order_stmt->execute();
$order_result = $order_stmt->get_result();

if ($order_result->num_rows == 0) {
    echo "No details found for this order.";
    exit();
}

$order = $order_result->fetch_assoc(); // Fetching one row for the order details

// Calculate the total cost
$total_cost = 0;
?>
    <div class="order-details-container">
    <div id="search_bar">
        <div>
            <span class="title" data-translate="Order Details">Order Details</span>
            <h2><img src="assets/images/navbar/notes.png" alt="Order"></h2>
        </div>
    </div>
    <h3>Order ID: <?php echo htmlspecialchars($order_id); ?></h3>
    <p>Order Date: <?php echo htmlspecialchars($order['order_date']); ?></p>
    <p>Order Status: <?php echo htmlspecialchars($order['order_status']); ?></p>
    <p>Shipping Method: <?php echo htmlspecialchars($order['shipping_name']); ?> (Fee: $<?php echo number_format($order['shipping_fee'], 2); ?>)</p>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product Image</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch all order items
            $order_stmt->execute();
            $order_result = $order_stmt->get_result();
            
            while ($item = $order_result->fetch_assoc()) {
                $item_total = $item['quantity'] * $item['product_price'];
                $total_cost += $item_total;
                ?>
                <tr>
                    <td><img src="assets/images/shop/<?php echo htmlspecialchars($item['product_image']); ?>" width="100"></td>
                    <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                    <td>$<?php echo number_format($item['product_price'], 2); ?></td>
                    <td>$<?php echo number_format($item_total, 2); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <?php
    // Assuming $total_cost and $order['shipping_fee'] are already defined
    $tax = $total_cost * 0.06; // 6% tax
    $shipping_fee = $order['shipping_fee']; // Shipping fee from the order
    $overall_total = $total_cost + $tax + $shipping_fee; // Overall total calculation
    ?>

<!-- Display Total Costs, Tax, and Overall Total -->
<h5>Total Cost: $<?php echo number_format($total_cost, 2); ?></h5>
<h5>Tax (6%): $<?php echo number_format($tax, 2); ?></h5>
<h5>Shipping Fee: $<?php echo number_format($shipping_fee, 2); ?></h5>
<h5>Overall Total: $<?php echo number_format($overall_total, 2); ?></h5>


</div>

    <script src="assets/js/header/currency.js"></script>
    <script src="assets/js/header/language.js"></script>
</body>
</html>
