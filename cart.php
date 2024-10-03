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

    <?php include_once('navigation/header.php'); ?>
    <?php include_once('navigation/sidebar.php'); ?>
       
    <!--Cart Container-->
    <section class="cart-container">     
        <h2 data-translate="Your Cart">Your Cart</h2>
        
        <table class="mt-4 pt-4">
            <thead>
                <tr>
                    <th data-translate="Product">Product</th>
                    <th data-translate="Quantity">Quantity</th>
                    <th data-translate="Price">Price</th>
                    <th data-translate="Total">Total</th>
                </tr>
            </thead>
            <tbody id="cart-items">
                <!-- Dynamic content will be inserted here by JavaScript -->
            </tbody>
        </table>
        <div class="cart-footer">
            <div class="total-price-container">
                <table>
                    <tr>
                        <td data-translate="Subtotal">Subtotal</td>
                        <td class="subtotal-price" data-price="0.00">USD 0.00</td>
                    </tr>
                    <tr>
                        <td data-translate="Tax">Tax</td>
                        <td class="tax-price" data-price="0.00">USD 0.00</td>
                    </tr>
                    <tr>
                        <td data-translate="Total">Total</td>
                        <td class="total-price" data-price="0.00">USD 0.00</td>
                    </tr>
                </table>
            </div>
            <div class="checkout-container">
                <a href="checkout.php" class="checkout-button" data-translate="Checkout">Checkout</a>
            </div>
        </div>
    </section>
    
</body>
    <script src="assets/js/header/currency.js"></script>
    <script src="assets/js/header/language.js"></script>
    <script src="assets/js/cart.js"></script>
</html>



