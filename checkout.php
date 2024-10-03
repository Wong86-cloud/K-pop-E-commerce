<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    
    <link rel="stylesheet" href="assets/css/bar.css">

    <link rel="stylesheet" href="assets/css/checkout.css">

</head>
<body>

    <?php include_once('navigation/header.php'); ?>
    <?php include_once('navigation/sidebar.php'); ?>
       
    <!-- Checkout Container -->
    <section class="checkout-container">   
        <h2 class="checkout-title" data-translate="Checkout">Checkout</h2>  
        <div class="container">

            <!-- Customer Information -->
            <div class="customer-info">
                <h3>Customer Information</h3>
                <form id="customer-info-form">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" placeholder="Your Full Name" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Your Email" required>

                    <div class="phone-input-container">
                        <label for="country-code">Country Code:</label>
                        <select id="country-code" name="country-code" required>
                            <option value="+1">US (+1)</option>
                            <option value="+44">UK (+44)</option>
                            <option value="+86">China (+86)</option>
                            <option value="+81">Japan (+81)</option>
                            <option value="+82">Korea (+82)</option>
                            <option value="+60">Malaysia (+60)</option>
                        </select>

                        <label for="phone-number">Phone Number:</label>
                        <input type="tel" id="phone-number" name="phone-number" placeholder="Enter your phone number" required>
                    </div>
                </form>
            </div>

            <!-- Shipping Address -->
            <div class="shipping-address">
                <h3>Shipping Address</h3>
                <form id="shipping-address-form">
                    <label for="address">Street Address:</label>
                    <input type="text" id="address" name="address" placeholder="1234 Main St" required>

                    <label for="postcode">Postcode:</label>
                    <input type="text" id="postcode" name="postcode" placeholder="Postcode" required>

                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" placeholder="City" required>

                    <label for="country-region">Country/Region:</label>
                    <select id="country-region" name="country-region" required>
                        <option value="China">China</option>
                        <option value="Korea">Korea</option>
                        <option value="Japan">Japan</option>
                        <option value="US">US</option>
                        <option value="UK">UK</option>
                        <option value="Malaysia">Malaysia</option>
                    </select>
                </form>
            </div>

            <!-- Shipping Options -->
            <div class="shipping-options">
            <h3>Shipping Options</h3>
                <form id="shipping-method-form">
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
                            <tr>
                                <td>
                                    <img src="assets/images/shipping/dhl.png" alt="DHL Logo" width="50">
                                </td>
                                <td>DHL Express Worldwide</td>
                                <td>1-3 business days</td>
                                <td>$20.00</td>
                                <td>
                                    <input type="radio" id="dhl" name="shipping-method" value="20" checked>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="assets/images/shipping/fedex.png" alt="FedEx Logo" width="50">
                                </td>
                                <td>FedEx International Priority</td>
                                <td>2-5 business days</td>
                                <td>$15.00</td>
                                <td>
                                    <input type="radio" id="fedex" name="shipping-method" value="15">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="assets/images/shipping/usps.png" alt="USPS Logo" width="50">
                                </td>
                                <td>USPS Priority Mail International</td>
                                <td>6-10 business days</td>
                                <td>$12.00</td>
                                <td>
                                    <input type="radio" id="usps" name="shipping-method" value="12">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>  

            <!-- Payment Method -->
            <div class="payment-method">
                <h3>Payment Method</h3>
                <form id="payment-method-form">
                    <label for="payment-method">Select Payment Method:</label>
                    <select id="payment-method" name="payment-method" required>
                        <option value="credit-card">Credit Card</option>
                        <option value="paypal">PayPal</option>
                    </select>
                </form>
            </div>

            <!-- Total Payment Section -->
            <div class="payment-summary">
                <h3>Total Payment</h3>
                <p>Product Price: <span id="product-price">$150.00</span></p>
                <p>Shipping Fee: <span id="shipping-fee">$0.00</span></p>
                <p>Total Price: <span id="total-price">$150.00</span></p>
                <button type="submit" class="pay-now-btn">Make Payment</button>
            </div>
            </form>
        </div>
        <h2 class="payment-title" data-translate="Payment Status">Payment Status</h2> 
        <div class="payment">
            <section class="payment-error">* Please fill in all the required fields.</section>
            <section class="payment-container">   
                <div class="payment-success">
                    <p>Payment Successful !</p>
                    <button id="view-order-button">View Your Order</button>
                </div>
            </section> 
        </div>
    </section>

    
</body>
    <script src="assets/js/header/currency.js"></script>
    <script src="assets/js/header/language.js"></script>
    <script src="assets/js/checkout.js"></script>
</html>
