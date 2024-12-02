<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    
    <link rel="stylesheet" href="assets/css/bar.css">

    <link rel="stylesheet" href="assets/css/checkout.css">

</head>
<body>

    <?php include_once('navigation/header.php'); ?>
    <?php include_once('navigation/sidebar.php'); ?>
    <?php
// Assuming user is logged in and user ID is stored in session
$user_id = $_SESSION['unique_id'];

// Fetch user details from the database
$query = "SELECT * FROM users WHERE unique_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Fetch cart details from the database
$cart_query = "SELECT * FROM cart WHERE unique_id = ?";
$cart_stmt = $conn->prepare($cart_query);
$cart_stmt->bind_param('i', $user_id);
$cart_stmt->execute();
$cart_result = $cart_stmt->get_result();


// Initialize variables
$cart_total = 0;
$tax = 0.05; // 5% tax for example
$shipping_fee = 0;
    
// Fetch shipping methods
$sql = "SELECT * FROM shipping_methods";
$result = $conn->query($sql);
?>

<section class="checkout-container">   
<div id="search_bar">
        <div>
            <span class="title" data-translate="Checkout">Checkout</span>
            <h2><img src="assets/images/navbar/checkout.png" alt="Order"></h2>
        </div>
    </div>
    <div class="container">
        <form id="order-form" method="POST" action="db_connection/place_order.php">
            <h3 data-translate="Customer Information">Customer Information</h3>
            <div class="col-md-12">
                <label for="name" data-translate="Name:">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($row['fname'] . " " . $row['lname']); ?>" placeholder="Your Full Name" required>

                <label for="email"data-translate="Email:">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" placeholder="Your Email" required>

                <div class="phone-input-container">
                    <label for="country-code" data-translate="Country Code:">Country Code:</label>
                    <select id="country_code" name="country_code" required>
                        <option value="+1" <?php echo ($row['country_code'] === '+1') ? 'selected' : ''; ?>>US (+1)</option>
                        <option value="+44" <?php echo ($row['country_code'] === '+44') ? 'selected' : ''; ?>>UK (+44)</option>
                        <option value="+86" <?php echo ($row['country_code'] === '+86') ? 'selected' : ''; ?>>China (+86)</option>
                        <option value="+81" <?php echo ($row['country_code'] === '+81') ? 'selected' : ''; ?>>Japan (+81)</option>
                        <option value="+82" <?php echo ($row['country_code'] === '+82') ? 'selected' : ''; ?>>Korea (+82)</option>
                        <option value="+60" <?php echo ($row['country_code'] === '+60') ? 'selected' : ''; ?>>Malaysia (+60)</option>
                    </select>

                    <label for="phone-number" data-translate="Phone Number:">Phone Number:</label>
                    <input type="tel" id="phone-number" name="phone_number" value="<?php echo htmlspecialchars($row['handphone']); ?>" placeholder="Enter your phone number" required>
                </div>
            </div>

            <h3 data-translate="Shipping Address">Shipping Address</h3>
            
            <div class="col-md-12">
                <label for="address"data-translate="Street Address:">Street Address:</label>
                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($row['address']); ?>" placeholder="1234 Main St" required>

                <label for="postcode"data-translate="Postcode:">Postcode:</label>
                <input type="text" id="postcode" name="postcode" value="<?php echo htmlspecialchars($row['postcode']); ?>" placeholder="Postcode" required>

                <label for="city" data-translate="City:">City:</label>
                <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($row['city']); ?>" placeholder="City" required>

                <label for="country-region"data-translate="Country/Region:">Country/Region:</label>
                <select id="country-region" name="country-region" required>
                    <option value="China" <?php echo ($row['country'] === 'China') ? 'selected' : ''; ?>>China</option>
                    <option value="South Korea" <?php echo ($row['country'] === 'South Korea') ? 'selected' : ''; ?>>South Korea</option>
                    <option value="Japan" <?php echo ($row['country'] === 'Japan') ? 'selected' : ''; ?>>Japan</option>
                    <option value="United States" <?php echo ($row['country'] === 'United States') ? 'selected' : ''; ?>>United States</option>
                    <option value="United Kingdom" <?php echo ($row['country'] === 'United Kingdom') ? 'selected' : ''; ?>>United Kingdom</option>
                    <option value="Malaysia" <?php echo ($row['country'] === 'Malaysia') ? 'selected' : ''; ?>>Malaysia</option>
                </select>
            </div>

            <h3 class="shipping-options-title" data-translate="Shipping Options">Shipping Options</h3>
            <div class="shipping-options">
            <table>
                <thead>
                    <tr>
                        <th data-translate="Logo">Logo</th>
                        <th data-translate="Shipping Type">Shipping Type</th>
                        <th data-translate="Expected Shipping Period">Expected Shipping Period</th>
                        <th data-translate="Shipping Fee">Shipping Fee</th>
                        <th data-translate="Select">Select</th>
                    </tr>
                </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($shipping_row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td><img src="' . htmlspecialchars($shipping_row['shipping_logo']) . '" alt="' . htmlspecialchars($shipping_row['shipping_name']) . ' Logo" width="50"></td>';
                echo '<td data-translate="' . htmlspecialchars($shipping_row['shipping_name']) . '">' . htmlspecialchars($shipping_row['shipping_name']) . '</td>';
                echo '<td data-translate="' . htmlspecialchars($shipping_row['shipping_period']) . '">' . htmlspecialchars($shipping_row['shipping_period']) . '</td>';
                echo '<td><span data-price="' . $shipping_row['shipping_fee'] . '">' . number_format($shipping_row['shipping_fee'], 2) . '</span></td>';
                echo '<td><input type="radio" id="shipping-method' . $shipping_row['shipping_id'] . '" name="shipping-method" value="' . $shipping_row['shipping_fee'] . '" onchange="updateOrderSummary()" ' . ($shipping_row['shipping_id'] == 1 ? ' checked' : '') . ' required></td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="5">No shipping methods available.</td></tr>';
        }
        ?>
        </tbody>
    </table>
</div>

<div class="cart-items">
    <h3 data-translate="Your Cart" >Your Cart</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th data-translate="Product Name">Product Name</th>
                <th data-translate="Price">Price</th>
                <th data-translate="Quantity">Quantity</th>
                <th data-translate="Total">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($cart_row = $cart_result->fetch_assoc()) {
                $item_total = $cart_row['quantity'] * $cart_row['product_price'];
                $cart_total += $item_total;
            ?>
                <tr>
                    <td>
                        <img src="assets/images/shop/<?php echo htmlspecialchars($cart_row['product_image']); ?>" alt="<?php echo htmlspecialchars($cart_row['product_name']); ?>" width="50">
                        <?php echo htmlspecialchars($cart_row['product_name']); ?>
                    </td>
                    <td data-price="<?php echo $cart_row['product_price']; ?>" >USD <?php echo number_format($cart_row['product_price'], 2); ?></td>
                    <td><?php echo htmlspecialchars($cart_row['quantity']); ?></td>
                    <td data-price="<?php echo $item_total; ?>" >USD <?php echo number_format($item_total, 2); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="order-summary">
    <h4 data-translate="Order Summary">Order Summary</h4>
    <div class="order-summary-row">
        <p data-translate="Cart Total:">Cart Total:</p>
        <span id="cart-total-display" data-price="<?php echo $cart_total; ?>"><?php echo number_format($cart_total, 2); ?></span>
    </div>
    <div class="order-summary-row">
        <p data-translate="Shipping Fee:">Shipping Fee:</p>
        <span id="shipping-fee-display" data-price="<?php echo $shipping_row['shipping_fee']; ?>"><?php echo number_format($shipping_row['shipping_fee'], 2); ?></span>
    </div>
    <div class="order-summary-row">
        <p data-translate="Tax:">Tax (<?php echo $tax * 100; ?>%):</p>
        <span id="tax-display" data-price="<?php echo $cart_total * $tax; ?>"><?php echo number_format($cart_total * $tax, 2); ?></span>
    </div>
    <div class="order-summary-row">
        <p data-translate="Overall Total:">Overall Total:</p>
        <span id="overall-total-display" data-price="<?php echo $cart_total; ?>"><?php echo number_format($cart_total, 2); ?></span>
    </div>
    <input type="hidden" id="hidden-shipping-method" name="shipping_id" value="<?php echo $shipping_row['shipping_id']; ?>"> 
    <input type="hidden" id="hidden-cart-total" name="order_cost" value="<?php echo $cart_total; ?>">
</div>

</div>
<h3 data-translate="Payment Options">Payment Options</h3>
<div class="payment-options">
    <label class="payment-option">
        <input type="radio" name="payment" value="credit_card" required>
        <i class="fas fa-credit-card"></i> Credit Card
    </label>

    <label class="payment-option">
        <input type="radio" name="payment" value="paypal" required>
        <i class="fab fa-paypal"></i> PayPal
    </label>
</div>

            <button type="submit" data-translate="Place Order">Place Order</button>
        </form>
    </div>
</section>


<!-- JavaScript to update totals -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const shippingMethods = document.querySelectorAll('input[name="shipping-method"]');
    const cartTotal = parseFloat(document.getElementById('cart-total-display').getAttribute('data-price'));
    const taxRate = <?php echo $tax; ?>;

    // Function to update the order summary
    function updateOrderSummary() {
        const selectedShippingMethod = document.querySelector('input[name="shipping-method"]:checked');
        const shippingFee = selectedShippingMethod ? parseFloat(selectedShippingMethod.value) : 0;
        
        // Calculate tax and overall total
        const taxAmount = cartTotal * taxRate;
        const overallTotal = cartTotal + shippingFee + taxAmount;

        // Update displayed values
        document.getElementById('shipping-fee-display').textContent = 'USD ' + shippingFee.toFixed(2);
        document.getElementById('tax-display').textContent = 'USD ' + taxAmount.toFixed(2);
        document.getElementById('overall-total-display').textContent = 'USD ' + overallTotal.toFixed(2);

        // Update hidden input values
        document.getElementById('hidden-shipping-method').value = selectedShippingMethod ? selectedShippingMethod.id.replace('shipping-method', '') : '';
        document.getElementById('hidden-cart-total').value = overallTotal.toFixed(2);
    }

    // Event listener for each shipping method radio button
    shippingMethods.forEach(method => {
        method.addEventListener('change', updateOrderSummary);
    });

    // Run calculation on page load to set initial values
    updateOrderSummary();

    // Form submission validation for shipping selection
    document.getElementById('order-form').addEventListener('submit', function (event) {
        const selectedShippingMethod = document.querySelector('input[name="shipping-method"]:checked');
        if (!selectedShippingMethod) {
            event.preventDefault();
            alert("Please select a shipping method.");
        }
    });
});
</script>
    
</body>
    <script src="assets/js/header/currency.js"></script>
    <script src="assets/js/header/language.js"></script>
</html>
