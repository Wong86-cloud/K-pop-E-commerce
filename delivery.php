<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <link rel="stylesheet" href="assets/css/bar.css">

    <link rel="stylesheet" href="assets/css/delivery.css">

</head>
<body>

<?php include_once('navigation/header.php'); ?>
<?php include_once('navigation/sidebar.php'); ?>

<div class="tracking-container">
    <h2>Your Purchases</h2>
    <div class="product-container">
        <div class="product">
            <img src="assets/images/shop/merch2.png" alt="Awesome Headphones" class="product-image">
            <div class="product-info">
                <div class="product-details">
                    <p><strong>Product:</strong> Awesome Headphones</p>
                    <p><strong>Quantity:</strong> 1</p>
                    <p><strong>Price:</strong> $50</p>
                    <p><strong>Total:</strong> $50</p>
                </div>
                <div class="product-actions">
                    <button class="track-btn" onclick="openTracking()">View Tracking</button>
                    <button class="review-btn" onclick="markAsReceived(this)">Mark as Received</button>
                </div>
            </div>
        </div>
        <div class="product">
            <img src="assets/images/shop/merch2.png" alt="Awesome Headphones" class="product-image">
            <div class="product-info">
                <div class="product-details">
                    <p><strong>Product:</strong> Awesome Headphones</p>
                    <p><strong>Quantity:</strong> 1</p>
                    <p><strong>Price:</strong> $50</p>
                    <p><strong>Total:</strong> $50</p>
                </div>
                <div class="product-actions">
                    <button class="track-btn" onclick="openTracking()">View Tracking</button>
                    <button class="review-btn" onclick="markAsReceived(this)">Mark as Received</button>
                </div>
            </div>
        </div>
        <div class="product">
            <img src="assets/images/shop/merch2.png" alt="Awesome Headphones" class="product-image">
            <div class="product-info">
                <div class="product-details">
                    <p><strong>Product:</strong> Awesome Headphones</p>
                    <p><strong>Quantity:</strong> 1</p>
                    <p><strong>Price:</strong> $50</p>
                    <p><strong>Total:</strong> $50</p>
                </div>
                <div class="product-actions">
                    <button class="track-btn" onclick="openTracking()">View Tracking</button>
                    <button class="review-btn" onclick="markAsReceived(this)">Mark as Received</button>
                </div>
            </div>
        </div>
        <div class="product">
            <img src="assets/images/shop/merch2.png" alt="Awesome Headphones" class="product-image">
            <div class="product-info">
                <div class="product-details">
                    <p><strong>Product:</strong> Awesome Headphones</p>
                    <p><strong>Quantity:</strong> 1</p>
                    <p><strong>Price:</strong> $50</p>
                    <p><strong>Total:</strong> $50</p>
                </div>
                <div class="product-actions">
                    <button class="track-btn" onclick="openTracking()">View Tracking</button>
                    <button class="review-btn" onclick="markAsReceived(this)">Mark as Received</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Delivery Tracking -->
    <div id="tracking-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeTracking()">&times;</span>
            <h3>Delivery Tracking</h3>
            <div id="tracking-history">
                <p><strong>Step 1:</strong> Shipped from Korea - 2024-09-18</p>
                <p><strong>Step 2:</strong> In Transit to Malaysia - 2024-09-19</p>
                <p><strong>Step 3:</strong> Arrived at Local Hub - 2024-09-20</p>
            </div>
            <button onclick="openChat()">Help: Report an Issue</button>
        </div>
    </div>

    <!-- Modal for Customer Service Chat -->
    <div id="chat-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeChat()">&times;</span>
            <h3>Customer Service Chat</h3>
            <div class="chat-box">
                <p><strong>Agent:</strong> How can I assist you?</p>
            </div>
            <input type="text" id="chat-input" placeholder="Type your message here...">
            <button onclick="sendMessage()">Send</button>
        </div>
    </div>
</div>

    

</html>
</body>
    <script src="assets/js/header/currency.js"></script>
    <script src="assets/js/header/language.js"></script>
    <script src="assets/js/delivery.js"></script>
</html>
