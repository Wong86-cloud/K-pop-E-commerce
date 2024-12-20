<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Single Product</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    
    <link rel="stylesheet" href="assets/css/bar.css">
    <link rel="stylesheet" href="assets/css/single_product.css">
</head>
<body>

    <?php include_once('navigation/header.php'); ?>
    <?php include_once('navigation/sidebar.php'); ?>

    <?php
    // Assuming you've already connected to the database
    $productId = isset($_GET['id']) ? (int)$_GET['id'] : 0; // Get product ID from the URL
    $productQuery = "SELECT * FROM products WHERE product_id = $productId"; // Replace with your table name
    $productResult = $conn->query($productQuery);

    if ($productResult->num_rows > 0) {
        $product = $productResult->fetch_assoc();
    } else {
        // Handle the case where the product is not found
        echo "<p>Product not found.</p>";
        exit;
    }
    ?>

    <section class="single-product-container">     
        <div class="product-row">
            <div class="product-image-column">
                <div class="main-img-container">
                    <img class="huge-img" src="assets/images/shop/<?php echo htmlspecialchars($product['product_image']); ?>" id="main-img" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                </div>
                    <div class="small-img-group">
                    <!-- Fetch additional related products based on celebrity only -->
                    <?php
                    $celebrity = $product['celebrity']; // Get the product celebrity
                
                    // SQL query to fetch related products by the same celebrity
                    $relatedQuery = "SELECT * FROM products WHERE celebrity = '$celebrity' AND product_id != " . $product['product_id'] . " LIMIT 4";
                    $relatedResult = $conn->query($relatedQuery);
                
                    // Check if related products exist
                    if ($relatedResult->num_rows > 0): 
                    ?>
                        <?php while ($relatedProduct = $relatedResult->fetch_assoc()): ?>
                            <div class="small-img-col">
                                <img src="assets/images/shop/<?php echo htmlspecialchars($relatedProduct['product_image']); ?>" width="100%" class="small-img" 
                                    data-title="<?php echo htmlspecialchars($relatedProduct['product_name']); ?>" 
                                    data-price="<?php echo htmlspecialchars($relatedProduct['product_price']); ?>" 
                                    data-details="<?php echo htmlspecialchars($relatedProduct['product_description']); ?>"/>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="product-info-column"> 
                <h6><?php echo htmlspecialchars($product['celebrity']); ?></h6> <!-- Assuming there's a celebrity field -->
                <h3 id="product-title" class="py-4" data-translate="<?php echo htmlspecialchars($product['product_name']); ?>"><?php echo htmlspecialchars($product['product_name']); ?></h3>
                <h2 id="product-price" data-price="<?php echo htmlspecialchars($product['product_price']); ?>">USD <?php echo htmlspecialchars($product['product_price']); ?></h2>
                <!-- Quantity Section -->
                <div class="quantity-section">
                    <input type="number" id="quantity-<?php echo $product['product_id']; ?>" value="1" min="1" max="10"/>
                    <!-- Pass both product ID and quantity to addToCart -->
                    <button class="buy-button" onclick="addToCart(<?php echo $product['product_id']; ?>)" data-translate="Add To Cart">Add To Cart</button>
                </div>
                <h4 data-translate="Product details">Product details</h4>
                <span id="product-details" data-translate="<?php echo htmlspecialchars($product['product_description']); ?> "><?php echo htmlspecialchars($product['product_description']); ?></span>
            </div>
            <?php $celebrityFilter = isset($_GET['celebrity']) ? $_GET['celebrity'] : ''; ?>
            <div class="return-to-shop">
                <a href="shop.php?celebrity=<?php echo urlencode($celebrityFilter); ?>" class="return-button" data-translate="Return to Shop">
                    <i class="fas fa-chevron-left"></i> Return to Shop
                </a>
            </div>

        </div>
    </section>

</body>
    <script src="assets/js/header/currency.js"></script>
    <script src="assets/js/header/language.js"></script>
    <script src="assets/js/single_product.js"></script>
</html>

 


