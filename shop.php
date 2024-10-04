<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    
    <link rel="stylesheet" href="assets/css/bar.css">

    <link rel="stylesheet" href="assets/css/shop.css">

</head>
<body>

    <?php include_once('navigation/header.php'); ?>
    <!--Search Bar-->
    <div id="search_bar">
        <div>
            <span class="forum-title" data-translate="K-POP Shop">K-POP Shop</span>
            <input type="text" id="search_box" data-translate="Search for product" placeholder="Search for product">
            <button id="search_button"><i class="fas fa-search"></i></button>
        </div>
    </div>
    <?php include_once('navigation/sidebar.php'); ?>
    
    <!--Filter Product Container-->
    <div class="filter-product-container">
        <div class="filter-product">
            <span class="filter-product-title" data-translate="Filter Products">Filter Products</span>
            <ul class="shop-filter">
                <li>
                    <label>
                        <input type="checkbox" name="filter" value="all" checked>
                        <span data-translate="All">All</span>
                    </label>
                    <label>
                        <input type="checkbox" name="filter" value="Merchandise">
                        <span data-translate="Merchandise">Merchandise</span>
                    </label>
                    <label>
                        <input type="checkbox" name="filter" value="Album">
                        <span data-translate="Album">Album</span>
                    </label>
                    <label>
                        <input type="checkbox" name="filter" value="Photobook">
                        <span data-translate="Photobook">Photobook</span>
                    </label>
                    <label>
                        <input type="checkbox" name="filter" value="Photocard">
                        <span data-translate="Photocard">Photocard</span>
                    </label>
                </li>
            </ul>            
        </div>
       <!-- Price Filter -->
        <div class="filter-price">
            <span class="filter-price-title">Filter Prices</span>
            <ul class="price-items">
                <li>
                    <label>
                        <input type="radio" name="price_order" value="Default">
                        <span>Default</span>
                    </label>
                    <label>
                        <input type="radio" name="price_order" value="LowToHigh" >
                        <span>Low to High</span>
                    </label>
                    <label>
                        <input type="radio" name="price_order" value="HighToLow" >
                        <span>High to Low</span>
                    </label>
                </li>
            </ul>
        </div>
    </div>

    <!-- Filter Celebrities' Shop Container -->
    <div class="celebrities-shop-container">
    <?php
    // Fetch the list of artists for the shop buttons
    $artists = $conn->query("SELECT name, button_img FROM artists");

    // Loop through the artists and display their button image
    while ($artist = $artists->fetch_assoc()):
        $celebrityName = urlencode($artist['name']); // Encode the name for URL
    ?>
        <button class="celebrity-btn" id="celebrity-text" onclick="window.location.href='shop.php?celebrity=<?php echo $celebrityName; ?>'">
            <img src="assets/images/artists/<?php echo htmlspecialchars($artist['button_img']); ?>" class="celebrity-image">
            <?php echo htmlspecialchars($artist['name']); ?>
        </button>
    <?php endwhile; ?>
    </div>

    <div class="shop-container">
        <?php
        // Define how many products you want to show per page
        $productsPerPage = 12; 

        // Get the current page number from the URL, defaulting to 1
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        // Calculate the starting product based on the current page
        $startFrom = ($currentPage - 1) * $productsPerPage;

        // Initialize filters from the GET request
        $celebrityFilter = isset($_GET['celebrity']) ? urldecode($_GET['celebrity']) : null;
        $categoryFilter = isset($_GET['category']) ? $_GET['category'] : 'all';
        $priceOrderFilter = isset($_GET['price_order']) ? $_GET['price_order'] : 'Default';

        // Build the count query
        $countQuery = "SELECT COUNT(*) as total FROM products WHERE 1";
        if ($celebrityFilter) {
            $countQuery .= " AND celebrity = '" . $conn->real_escape_string($celebrityFilter) . "'";
        }
        if ($categoryFilter !== 'all') {
            $countQuery .= " AND category = '" . $conn->real_escape_string($categoryFilter) . "'";
        }

        // Get the total number of products
        $countResult = $conn->query($countQuery);
        $totalProducts = $countResult->fetch_assoc()['total'];

        // Calculate the total number of pages
        $totalPages = ceil($totalProducts / $productsPerPage);

        // Build the main query with LIMIT
        $query = "SELECT * FROM products WHERE 1";
        if ($celebrityFilter) {
            $query .= " AND celebrity = '" . $conn->real_escape_string($celebrityFilter) . "'";
        }
        if ($categoryFilter !== 'all') {
            $query .= " AND category = '" . $conn->real_escape_string($categoryFilter) . "'";
        }

        // Add LIMIT for pagination
        $query .= " LIMIT $startFrom, $productsPerPage";

        // Execute the query to fetch products
        $items = $conn->query($query);
        ?>

    <!-- Display products -->
    <ul class="shop-items">
        <?php while ($item = $items->fetch_assoc()): ?>
            <li data-category="<?php echo $item['category']; ?>" data-product-id="<?php echo $item['product_id']; ?>">
                <picture>
                    <img src="assets/images/shop/<?php echo $item['image']; ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                </picture>
                <div class="item-description">
                    <div class="icon">
                        <span class="wishlist-icon" oonclick="addToWishlist(<?php echo $item['product_id']; ?>, this)">
                            <i class="fas fa-heart" style="color:gray"></i>
                        </span>
                        <span class="add-to-cart" onclick="addToCart(this)">
                            <i class="fas fa-cart-plus"></i>
                        </span>
                    </div>
                    <strong><?php echo htmlspecialchars($item['name']); ?></strong>
                    <span class="product-price" data-price="<?php echo htmlspecialchars($item['price']); ?>">
                        USD <?php echo htmlspecialchars($item['price']); ?>
                    </span>
                    <small class="buy-now-text"><a href="single_product.php?id=<?php echo $item['product_id']; ?>">View Product</a></small>
                </div>
            </li>
        <?php endwhile; ?>
    </ul>
    </div>

    <!-- Pagination -->
    <div class="pagination">
        <?php if ($currentPage > 1): ?>
            <a href="?page=<?php echo $currentPage - 1; ?>&celebrity=<?php echo urlencode($celebrityFilter); ?>&category=<?php echo urlencode($categoryFilter); ?>&price_order=<?php echo urlencode($priceOrderFilter); ?>">Previous</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?php echo $i; ?>&celebrity=<?php echo urlencode($celebrityFilter); ?>&category=<?php echo urlencode($categoryFilter); ?>&price_order=<?php echo urlencode($priceOrderFilter); ?>" 
                <?php if ($i == $currentPage) echo 'class="active"'; ?>><?php echo $i; ?></a>
        <?php endfor; ?>

        <?php if ($currentPage < $totalPages): ?>
            <a href="?page=<?php echo $currentPage + 1; ?>&celebrity=<?php echo urlencode($celebrityFilter); ?>&category=<?php echo urlencode($categoryFilter); ?>&price_order=<?php echo urlencode($priceOrderFilter); ?>">Next</a>
        <?php endif; ?>
    </div>

</body>
    <script src="assets/js/header/currency.js"></script>
    <script src="assets/js/header/language.js"></script>
    <script src="assets/js/filter.js"></script>
    <script src="assets/js/shop.js"></script>
</html>



