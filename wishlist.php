<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <link rel="stylesheet" href="assets/css/bar.css">
    <link rel="stylesheet" href="assets/css/wishlist.css">
</head>
<body>

    <?php include_once('navigation/header.php'); ?>
    <!-- Search Bar -->
    <div id="search_bar">
        <div>
            <span class="forum-title" data-translate="K-POP Wishlist">K-POP Wishlist</span>
            <input type="text" id="search_box" data-translate="Search for products" placeholder="Search for products">
            <button id="search_button"><i class="fas fa-search"></i></button>
        </div>
    </div>
    <?php include_once('navigation/sidebar.php'); ?>
    
    <div class="wishlist-container">     
        <ul class="wishlist-items">
        <?php
        // Check if unique_id is set
        $unique_id = $_SESSION['unique_id'];

        // Fetching wishlist items for the logged-in user
        $query = "SELECT p.product_id, p.name, p.image, p.price, p.category 
                  FROM wishlist w 
                  JOIN products p ON w.product_id = p.product_id 
                  WHERE w.unique_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $unique_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($item = $result->fetch_assoc()) {
                ?>
                <li data-category="<?php echo htmlspecialchars($item['category']); ?>" data-product-id="<?php echo $item['product_id']; ?>">
                    <picture>
                        <img src="assets/images/shop/<?php echo $item['image']; ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                    </picture>
                    <div class="item-description">
                        <div class="icon">
                            <span class="wishlist-icon" data-added="true" onclick="toggleLike(this)">
                                <i class="fas fa-heart" style="color:red"></i> <!-- Heart is red since it's already in the wishlist -->
                            </span>
                            <span class="add-to-cart" onclick="addToCart(this)">
                                <i class="fas fa-cart-plus"></i>
                            </span>
                        </div>
                        <strong><?php echo htmlspecialchars($item['name']); ?></strong>
                        <span class="product-price">USD <?php echo htmlspecialchars($item['price']); ?></span>
                        <small><a href="single_product.php?id=<?php echo $item['product_id']; ?>">View Product</a></small>
                    </div>
                </li>
                <?php
            }
        } else {
            echo '<li>No items found in your wishlist.</li>';
        }
        ?>
        </ul>
    </div>

    <script src="assets/js/header/currency.js"></script>
    <script src="assets/js/header/language.js"></script>
    <script src="assets/js/filter.js"></script>
    <script src="assets/js/wishlist.js"></script>
</body>
</html>
