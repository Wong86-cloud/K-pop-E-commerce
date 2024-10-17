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
$tax = 0.06; // 6% tax for example
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
            <h3>Customer Information</h3>
            <div class="col-md-12">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($row['fname'] . " " . $row['lname']); ?>" placeholder="Your Full Name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" placeholder="Your Email" required>

                <div class="phone-input-container">
                    <label for="country-code">Country Code:</label>
                    <select id="country_code" name="country_code" required>
                        <option value="+1" <?php echo ($row['country_code'] === '+1') ? 'selected' : ''; ?>>US (+1)</option>
                        <option value="+44" <?php echo ($row['country_code'] === '+44') ? 'selected' : ''; ?>>UK (+44)</option>
                        <option value="+86" <?php echo ($row['country_code'] === '+86') ? 'selected' : ''; ?>>China (+86)</option>
                        <option value="+81" <?php echo ($row['country_code'] === '+81') ? 'selected' : ''; ?>>Japan (+81)</option>
                        <option value="+82" <?php echo ($row['country_code'] === '+82') ? 'selected' : ''; ?>>Korea (+82)</option>
                        <option value="+60" <?php echo ($row['country_code'] === '+60') ? 'selected' : ''; ?>>Malaysia (+60)</option>
                    </select>

                    <label for="phone-number">Phone Number:</label>
                    <input type="tel" id="phone-number" name="phone_number" value="<?php echo htmlspecialchars($row['handphone']); ?>" placeholder="Enter your phone number" required>
                </div>
            </div>

            <h3>Shipping Address</h3>
            
            <div class="col-md-12">
                <label for="address">Street Address:</label>
                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($row['address']); ?>" placeholder="1234 Main St" required>

                <label for="postcode">Postcode:</label>
                <input type="text" id="postcode" name="postcode" value="<?php echo htmlspecialchars($row['postcode']); ?>" placeholder="Postcode" required>

                <label for="city">City:</label>
                <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($row['city']); ?>" placeholder="City" required>

                <label for="country-region">Country/Region:</label>
                <select id="country-region" name="country-region" required>
                    <option value="China" <?php echo ($row['country'] === 'China') ? 'selected' : ''; ?>>China</option>
                    <option value="South Korea" <?php echo ($row['country'] === 'South Korea') ? 'selected' : ''; ?>>South Korea</option>
                    <option value="Japan" <?php echo ($row['country'] === 'Japan') ? 'selected' : ''; ?>>Japan</option>
                    <option value="United States" <?php echo ($row['country'] === 'United States') ? 'selected' : ''; ?>>United States</option>
                    <option value="United Kingdom" <?php echo ($row['country'] === 'United Kingdom') ? 'selected' : ''; ?>>United Kingdom</option>
                    <option value="Malaysia" <?php echo ($row['country'] === 'Malaysia') ? 'selected' : ''; ?>>Malaysia</option>
                </select>
            </div>

            <h3 class="shipping-options-title">Shipping Options</h3>
            <div class="shipping-options">
            <table>
                <thead>
                    <tr>
                        <th>Logo</th>
                        <th>Shipping Type</th>
                        <th>Expected Shipping Period</th>
                        <th>Shipping Fee</th>
                        <th>Select</th>
                    </tr>
                </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($shipping_row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td><img src="' . htmlspecialchars($shipping_row['shipping_logo']) . '" alt="' . htmlspecialchars($shipping_row['shipping_name']) . ' Logo" width="50"></td>';
                echo '<td>' . htmlspecialchars($shipping_row['shipping_name']) . '</td>';
                echo '<td>' . htmlspecialchars($shipping_row['shipping_period']) . '</td>';
                echo '<td>$' . number_format($shipping_row['shipping_fee'], 2) . '</td>'; // Display shipping fee
                echo '<td><input type="radio" id="shipping-method' . $shipping_row['shipping_id'] . '" name="shipping-method" value="' . $shipping_row['shipping_fee'] . '"' . ($shipping_row['shipping_id'] == 1 ? ' checked' : '') . ' required></td>';
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
    <h3>Your Cart</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
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
                    <td>$<?php echo number_format($cart_row['product_price'], 2); ?></td>
                    <td><?php echo htmlspecialchars($cart_row['quantity']); ?></td>
                    <td>$<?php echo number_format($item_total, 2); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="order-summary">
        <h4>Order Summary</h4>
        <p>Cart Total: $<span id="cart-total-display"><?php echo number_format($cart_total, 2); ?></span></p>
        <p>Shipping Fee: $<span id="shipping-fee-display">0.00</span></p>
        <p>Tax (<?php echo $tax * 100; ?>%): $<span id="tax-display"><?php echo number_format($cart_total * $tax, 2); ?></span></p>
        <p>Overall Total: $<span id="overall-total-display"><?php echo number_format($cart_total, 2); ?></span></p>
        <input type="hidden" id="hidden-shipping-method" name="shipping_id" value="<?php echo $shipping_row['shipping_id']; ?>"> 
        <input type="hidden" id="hidden-cart-total" name="order_cost" value="<?php echo $cart_total; ?>">
    </div>
</div>
<h3>Payment Options</h3>
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

            <button type="submit">Place Order</button>
        </form>
    </div>
</section>


<!-- JavaScript to update totals -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const shippingMethods = document.querySelectorAll('input[name="shipping-method"]');
    const shippingFeeDisplay = document.getElementById('shipping-fee-display');

    shippingMethods.forEach(method => {
        method.addEventListener('change', function () {
            // Parse the selected shipping fee directly from the radio button value
            const selectedFee = parseFloat(this.value); // this.value now contains the shipping fee

            // Update the hidden input value for shipping method
            document.getElementById('hidden-shipping-method').value = this.id.replace('shipping-method', ''); // Get the shipping_id

            // Update the shipping fee display
            shippingFeeDisplay.textContent = selectedFee.toFixed(2);
            updateOverallTotal(selectedFee); // Update the overall total with the new shipping fee
        });
    });

    function updateOverallTotal(shippingFee) {
    const cartTotal = parseFloat(document.getElementById('cart-total-display').textContent);
    const taxAmount = cartTotal * <?php echo $tax; ?>;
    const overallTotal = cartTotal + shippingFee + taxAmount;

    // Update the overall total display
    document.getElementById('overall-total-display').textContent = overallTotal.toFixed(2);
    
    // Update the hidden input for order cost (which is the overall total)
    document.getElementById('hidden-cart-total').value = overallTotal.toFixed(2); // Update the hidden field with overall total
}

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
