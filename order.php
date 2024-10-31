<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <link rel="stylesheet" href="assets/css/bar.css">
    <link rel="stylesheet" href="assets/css/order.css">
</head>
<body>

    <?php 
    include_once('navigation/header.php'); 
    include_once('navigation/sidebar.php'); 
    
// Assuming user is logged in and user ID is stored in session
$user_id = $_SESSION['unique_id'];

// Fetch orders for the logged-in user
$query = "SELECT order_id, order_date, order_cost, order_status FROM orders WHERE unique_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if an order_id is passed in the URL
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : null;

// Fetch order details if order_id is set
$order_details = [];
if ($order_id) {
    $order_details_query = "SELECT * FROM orders WHERE order_id = ? AND unique_id = ?";
    $order_details_stmt = $conn->prepare($order_details_query);
    $order_details_stmt->bind_param("ii", $order_id, $user_id);
    $order_details_stmt->execute();
    $order_details_result = $order_details_stmt->get_result();

    if ($order_details_result->num_rows > 0) {
        $order_details = $order_details_result->fetch_assoc();
    } else {
        echo "No details found for this order.";
    }
}
?>
    <div class="order-container">
    <div id="search_bar">
        <div>
            <span class="title" data-translate="K-POP Order">K-POP Order</span>
            <h2><img src="assets/images/navbar/order.png" alt="Order"></h2>
        </div>
    </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th data-translate="Order ID">Order ID</th>
                    <th data-translate="Order Date">Order Date</th>
                    <th data-translate="Order Cost">Order Cost</th>
                    <th data-translate="Order Status">Order Status</th>
                    <th data-translate="View Details">View Details</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                        <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                        <td data-price="<?php echo($order['order_cost']);?>"><?php echo number_format($order['order_cost'], 2); ?></td>
                        <td data-translate="<?php echo($order['order_status']);?>"><?php echo htmlspecialchars($order['order_status']); ?></td>
                        <td>
                            <a href="order_details.php?order_id=<?php echo $order['order_id']; ?>" class="btn btn-primary" data-translate="View">View</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="assets/js/header/currency.js"></script>
    <script src="assets/js/header/language.js"></script>
</body>
</html>
