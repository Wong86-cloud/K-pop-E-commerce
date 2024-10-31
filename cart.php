<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <link rel="stylesheet" href="assets/css/bar.css">
    <link rel="stylesheet" href="assets/css/cart.css">
</head>
<body>

    <?php 
    include_once('navigation/header.php'); 
    include_once('navigation/sidebar.php'); 

    $user_id = $_SESSION['unique_id']; // Assuming unique_id is stored in session

    // Fetch cart items for the logged-in user
    $query = "SELECT * FROM cart WHERE unique_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id); // Bind the unique_id parameter
    $stmt->execute();
    $result = $stmt->get_result(); // Get the result set

    $cart_items = $result->fetch_all(MYSQLI_ASSOC); // Fetch all cart items as an associative array

    $subtotal = 0;
    $taxRate = 0.07; // Example tax rate

    // Check if the form has been submitted and values exist
    if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];

        // Fetch product details from the products table
        $query = "SELECT * FROM cart WHERE unique_id = <your_user_id>;";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
        
        // Insert into cart table with product details
        $insert_query = "INSERT INTO cart (unique_id, product_id, product_name, product_image, product_price, quantity)
                            VALUES (?, ?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bind_param('iissdi', $user_id, $product_id, $product['product_name'], $product['product_image'], 
                        $product['product_price'], $quantity);
        $insert_stmt->execute();

        } else {
            echo "Product not found for ID: " . htmlspecialchars($product_id);
        }
    }
    ?>


    <section class="cart-container">   
    <div id="search_bar">
        <div>
            <span class="title" data-translate="K-POP Cart">K-POP Cart</span>
            <h2><img src="assets/images/navbar/cart.png" alt="Order"></h2>
        </div>
    </div>
        <table class="cart-items" id="cart-items">
            <thead>
                <tr>
                    <th data-translate="Product">Product</th>
                    <th data-translate="Quantity">Quantity</th>
                    <th data-translate="Price">Price</th>
                    <th data-translate="Total">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($cart_items as $item) : 
                // Check if the keys exist before using them
                $itemQuantity = isset($item['quantity']) ? $item['quantity'] : 0;
                $itemPrice = isset($item['product_price']) ? $item['product_price'] : 0;

                $itemTotal = $itemQuantity * $itemPrice;
                $subtotal += $itemTotal;
                ?>
                <tr data-id="<?php echo $item['product_id']; ?>">
                    <td>
                        <img src="assets/images/shop/<?php echo $item['product_image']; ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>">
                        <p data-translate="<?php echo htmlspecialchars($item['product_name']); ?>"><?php echo htmlspecialchars($item['product_name']); ?></p>
                    </td>
                    <td>
                        <input type="number" value="<?php echo $itemQuantity; ?>" min="1" class="quantity-input">
                        <a class="remove-button" href="#" onclick="removeFromCart('<?php echo $item['product_id']; ?>'); return false;" data-translate="Remove">Remove</a>
                    </td>
                    <td data-price="<?php echo $itemPrice; ?>">USD <?php echo number_format($itemPrice, 2); ?></td>
                    <td data-price="<?php echo $itemTotal; ?>">USD <?php echo number_format($itemTotal, 2); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Cart Footer showing the subtotal, tax, and overall total -->
        <div class="cart-footer">
            <table>
            <tr>
                <td data-translate="Subtotal">Subtotal</td>
                <td class="subtotal-price" data-price="<?php echo $subtotal; ?>">USD <?php echo number_format($subtotal, 2); ?></td>
            </tr>
            <tr>
                <td data-translate="Tax">Tax</td>
                <?php $tax = $subtotal * $taxRate; ?>
                <td class="tax-price" data-price="<?php echo $tax; ?>">USD <?php echo number_format($tax, 2); ?></td>
            </tr>
            <tr>
                <td data-translate="Total">Total</td>
                <td class="total-price" data-price="<?php echo $subtotal + $tax; ?>">USD <?php echo number_format($subtotal + $tax, 2); ?></td>
            </tr>
            </table>
            <form action="checkout.php" method="POST">
                <input type="hidden" name="cart_total" value="<?php echo $subtotal + $tax; ?>">
                <button type="submit" class="checkout-btn">Checkout</button>
            </form>
        </div>
    </section>
    
    <script src="assets/js/header/currency.js"></script>
    <script src="assets/js/header/language.js"></script>
    <script src="assets/js/cart.js"></script>
</body>
</html>
