<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" crossorigin="anonymous"/>
    <link rel="stylesheet" href="assets/css/bar.css">
    <link rel="stylesheet" href="assets/css/wishlist.css">
</head>
<body>

    <?php include_once('navigation/header.php'); ?>
    <div id="search_bar">
        <div>
            <span class="title" data-translate="K-POP Wishlist">K-POP Wishlist</span>
            <img src="assets/images/navbar/music.png" alt="Wishlist">
            <img src="assets/images/navbar/disc.jfif" alt="Wishlist">
            <img src="assets/images/navbar/headphones.png" alt="Wishlist">
            <img src="assets/images/navbar/mic.png" alt="Wishlist">
            <img src="assets/images/navbar/love.png" alt="Wishlist">
        </div>
    </div>
    <?php include_once('navigation/sidebar.php'); ?>
    
    <div class="wishlist-container">     
        <ul class="wishlist-items">
        <?php
        // Check if unique_id is set
        $unique_id = $_SESSION['unique_id'];

        // Pagination setup
        $itemsPerPage = 12; 
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
        $offset = ($page - 1) * $itemsPerPage; 

        // Fetching wishlist items for the logged-in user
        $query = "SELECT p.product_id, p.product_name, p.product_image, p.product_price, p.product_category 
                  FROM wishlist w 
                  JOIN products p ON w.product_id = p.product_id 
                  WHERE w.unique_id = ? 
                  LIMIT ?, ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iii", $unique_id, $offset, $itemsPerPage);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($item = $result->fetch_assoc()) {
                ?>
                <li data-category="<?php echo htmlspecialchars($item['product_category']); ?>" data-product-id="<?php echo $item['product_id']; ?>">
                    <picture>
                        <img src="assets/images/shop/<?php echo $item['product_image']; ?>">
                    </picture>
                    <div class="item-description">
                        <div class="icon">
                            <span class="wishlist-icon" data-added="true" onclick="toggleLike(this)">
                                <i class="fas fa-heart" style="color:red"></i>
                            </span>
                            <span class="add-to-cart" onclick="addToCart(<?php echo $item['product_id']; ?>)">
                                <i class="fas fa-cart-plus"></i>
                            </span>
                        </div>
                        <strong><?php echo htmlspecialchars($item['product_name']); ?></strong>
                        <span class="product-price">USD <?php echo htmlspecialchars($item['product_price']); ?></span>
                        <small><a href="single_product.php?id=<?php echo $item['product_id']; ?>">View Product</a></small>
                    </div>
                </li>
                <?php
            }
        } else {
            echo '<li>No items found in your wishlist.</li>';
        }

        // Count total items for pagination
        $countQuery = "SELECT COUNT(*) as total FROM wishlist WHERE unique_id = ?";
        $countStmt = $conn->prepare($countQuery);
        $countStmt->bind_param("i", $unique_id);
        $countStmt->execute();
        $countResult = $countStmt->get_result();
        $totalItems = $countResult->fetch_assoc()['total'];
        $totalPages = ceil($totalItems / $itemsPerPage);
        ?>
        </ul>
    </div>

    <!-- Pagination Links -->
<div class="pagination">
    <?php
    if ($totalPages > 1) {
        if ($page > 1) {
            echo '<a href="?page=1" class="pagination-link">First</a>';
            echo '<a href="?page=' . ($page - 1) . '" class="pagination-link">Previous</a>';
        }

        // Display page numbers
        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i == $page) {
                echo '<span class="pagination-current">' . $i . '</span>'; // Current page
            } else {
                echo '<a href="?page=' . $i . '" class="pagination-link">' . $i . '</a>'; // Other pages
            }
        }

        if ($page < $totalPages) {
            echo '<a href="?page=' . ($page + 1) . '" class="pagination-link">Next</a>';
            echo '<a href="?page=' . $totalPages . '" class="pagination-link">Last</a>';
        }
    }
    ?>
</div>

    <script src="assets/js/header/currency.js"></script>
    <script src="assets/js/header/language.js"></script>
    <script src="assets/js/wishlist.js"></script>
</body>
</html>



