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
    <div class="order-line">
        <h3 data-translate="Order ID:">Order ID:</h3>
        <h5><?php echo htmlspecialchars($order_id); ?></h5>
    </div>
    <div class="order-line">
        <p data-translate="Order Date:">Order Date:</p>
        <span><?php echo htmlspecialchars($order['order_date']); ?></span>
    </div>
    <div class="order-line">
        <p data-translate="Order Status:">Order Status: </p>
        <span data-translate="<?php echo htmlspecialchars($order['order_status']); ?>" ><?php echo htmlspecialchars($order['order_status']); ?></span>
    </div>
    <div class="order-line">
        <p data-translate="Shipping Method:" >Shipping Method:</p>
        <span data-translate="<?php echo htmlspecialchars($order['shipping_name']); ?>"><?php echo htmlspecialchars($order['shipping_name']); ?></span>
    </div>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th data-translate="Product Image">Product Image</th>
                <th data-translate="Product Name">Product Name</th>
                <th data-translate="Quantity">Quantity</th>
                <th data-translate="Price">Price</th>
                <th data-translate="Total">Total</th>
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
                    <td data-translate="<?php echo htmlspecialchars($item['product_name']); ?>"><?php echo htmlspecialchars($item['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                    <td data-price="<?php echo $item['product_price']; ?>" >USD <?php echo number_format($item['product_price'], 2); ?></td>
                    <td data-price="<?php echo $item_total; ?>">USD <?php echo number_format($item_total, 2); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <?php
    // Assuming $total_cost and $order['shipping_fee'] are already defined
    $tax = $total_cost * 0.05; // 5% tax
    $shipping_fee = $order['shipping_fee']; // Shipping fee from the order
    $overall_total = $total_cost + $tax + $shipping_fee; // Overall total calculation
    ?>

    <!-- Display Total Costs, Tax, and Overall Total -->
    <div class="order-line">
        <h5 data-translate="Total Cost:">Total Cost:</h5>
        <span data-price="<?php echo $total_cost; ?>">USD <?php echo number_format($total_cost, 2); ?></span>
    </div>
    <div class="order-line">
        <h5 data-translate="Tax (5%):">Tax (5%):</h5>
        <span data-price="<?php echo $tax; ?>">USD <?php echo number_format($tax, 2); ?></span>
    </div>
    <div class="order-line">
        <h5 data-translate="Shipping Fee:">Shipping Fee:</h5> 
        <span data-price="<?php echo $shipping_fee; ?>">USD <?php echo number_format($shipping_fee, 2); ?></span>
    </div>
    <div class="order-line">
        <h5 data-translate="Overall Total:">Overall Total:</h5>
        <span data-price="<?php echo $overall_total; ?>">USD <?php echo number_format($overall_total, 2); ?></span>
    </div>
</div>

<div class="report-issue-container">
    <h4 data-translate="Report an Issue">Report an Issue</h4>
    <form method="POST" action="db_connection/report_issue.php" enctype="multipart/form-data">
        <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order_id); ?>">
        <div class="mb-3">
            <label for="issue_description" class="form-label" data-translate="Issue Description:">Issue Description:</label>
            <textarea id="issue_description" name="issue_description" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label for="issue_image" class="form-label" data-translate="Upload Image (if applicable):">Upload Image (if applicable):</label>
            <input type="file" id="issue_image" name="issue_image" class="form-control" accept="image/*">
        </div>
        <button type="submit" class="btn btn-danger" data-translate="Report Issue">Report Issue</button>
    </form>
</div>

<div class="mark-received-container">
    <h4 data-translate="Mark as Received">Mark as Received</h4>
    <form method="POST" action="db_connection/mark_received.php">
        <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order_id); ?>">
        <button type="submit" class="btn btn-success" data-translate="Mark as Received">Mark as Received</button>
    </form>
</div>

    <script src="assets/js/header/currency.js"></script>
    <script src="assets/js/header/language.js"></script>
</body>
</html>
