<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message</title>

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
            <span class="forum-title" data-translate="K-POP Wishlist">K-POP Wishlist</span>
            <input type="text" id="search_box" data-translate="Search for people" placeholder="Search for people">
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
                        <input type="checkbox" name="filter" value="Merch">
                        <span data-translate="Merch">Merch</span>
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
        <div class="filter-price">
            <span class="filter-price-title" data-translate="Filter Prices">Filter Prices</span>
            <ul class="price-items" id="select">
                <li>
                    <label>
                        <input type="radio" name="filter" value="Default" checked>
                        <span data-translate="Default">Default</span>
                    </label>
                    <label>
                        <input type="radio" name="filter" value="LowToHigh">
                        <span data-translate="Low to High">Low to high</span>
                    </label>
                    <label>
                        <input type="radio" name="filter" value="HighToLow">
                        <span data-translate="High to Low">High to low</span>
                    </label>
                </li>
            </ul>
        </div>
    </div>

    <!--Wishlist Container-->
    <div class="shop-container">     
        <div class="shop-items">
             <!-- Wishlist items will be inserted here dynamically -->
        </div>
    </div>
</body>
    <script src="assets/js/header/currency.js"></script>
    <script src="assets/js/header/language.js"></script>
    <script src="assets/js/filter.js"></script>
    <script src="assets/js/wishlist.js"></script>
</html>
