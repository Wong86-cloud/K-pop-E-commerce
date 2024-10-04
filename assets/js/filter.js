document.addEventListener('DOMContentLoaded', function() {
    const filterProductCheckboxes = document.querySelectorAll('input[type="checkbox"][name="filter"]');
    const filterPriceRadios = document.querySelectorAll('input[type="radio"][name="price_order"]');
    const productItems = document.querySelectorAll('.shop-items li');
    const searchBox = document.getElementById('search_box'); // The search input box
    const searchButton = document.getElementById('search_button'); // The search button

    function filterProducts() {
        let selectedCategories = [];
        let selectedPriceFilter = 'Default';
        const searchQuery = searchBox.value.toLowerCase().trim(); // Get the search input and convert it to lowercase

        console.log("Search query: ", searchQuery); // Debugging search query
        
        // Get selected categories
        filterProductCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                selectedCategories.push(checkbox.value);
            }
        });

        // Get selected price filter
        filterPriceRadios.forEach(radio => {
            if (radio.checked) {
                selectedPriceFilter = radio.value;
            }
        });

        // Filter products based on category and search query
        productItems.forEach(item => {
            const category = item.getAttribute('data-category');
            const price = parseFloat(item.querySelector('.product-price').getAttribute('data-price'));
            const productName = item.querySelector('strong').textContent.toLowerCase(); // Product name to match

            const matchesCategory = selectedCategories.includes('all') || selectedCategories.includes(category);
            const matchesSearch = productName.includes(searchQuery);

            console.log("Product name: ", productName, "Matches search: ", matchesSearch); // Debugging product name match

            // Show or hide items based on category and search query
            if (matchesCategory && matchesSearch) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });

        // Sort products based on price filter
        let sortedItems = Array.from(productItems).filter(item => item.style.display !== 'none');
        if (selectedPriceFilter === 'LowToHigh') {
            sortedItems.sort((a, b) => parseFloat(a.querySelector('.product-price').getAttribute('data-price')) - parseFloat(b.querySelector('.product-price').getAttribute('data-price')));
        } else if (selectedPriceFilter === 'HighToLow') {
            sortedItems.sort((a, b) => parseFloat(b.querySelector('.product-price').getAttribute('data-price')) - parseFloat(a.querySelector('.product-price').getAttribute('data-price')));
        }

        // Get the shop items container
        const shopItemsContainer = document.querySelector('.shop-items');

function fetchProducts(page = 1) {
    const celebrity = new URLSearchParams(window.location.search).get('celebrity');
    const category = new URLSearchParams(window.location.search).get('category');

    fetch(`fetch_products.php?page=${page}&celebrity=${encodeURIComponent(celebrity)}&category=${encodeURIComponent(category)}`)
        .then(response => response.json())
        .then(data => {
            if (shopItemsContainer) {
                shopItemsContainer.innerHTML = ''; // Clear current items

                // Loop through the products and create HTML
                data.items.forEach(item => {
                    const itemElement = document.createElement('li');
                    itemElement.setAttribute('data-category', item.category);
                    itemElement.setAttribute('data-product-id', item.product_id);

                    itemElement.innerHTML = `
                        <picture>
                            <img src="assets/images/shop/${item.image}" alt="${item.name}">
                        </picture>
                        <div class="item-description">
                            <div class="icon">
                                <span class="wishlist-icon" onclick="addToWishlist(${item.product_id}, this)">
                                    <i class="fas fa-heart" style="color: gray"></i>
                                </span>
                                <span class="add-to-cart" onclick="addToCart(this)">
                                    <i class="fas fa-cart-plus"></i>
                                </span>
                            </div>
                            <strong>${item.name}</strong>
                            <span class="product-price" data-price="${item.price}">
                                USD ${item.price}
                            </span>
                            <small class="buy-now-text"><a href="single_product.php?id=${item.product_id}">Buy Now</a></small>
                        </div>
                    `;

                    shopItemsContainer.appendChild(itemElement);
                });
            } else {
                console.error('The shop items container could not be found.');
            }
        })
        .catch(error => console.error('Error fetching products:', error));
}

// Call fetchProducts on page load
document.addEventListener('DOMContentLoaded', () => fetchProducts());

    }

    // Add event listeners to checkboxes, radio buttons, and search box
    filterProductCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', filterProducts);
    });
    filterPriceRadios.forEach(radio => {
        radio.addEventListener('change', filterProducts);
    });
    
    // Listen for search input changes or button click to trigger filtering
    searchBox.addEventListener('input', function() {
        console.log("Search input changed: ", searchBox.value);
        filterProducts();
    });
    searchButton.addEventListener('click', function() {
        console.log("Search button clicked");
        filterProducts();
    });    

    // Initial filter
    filterProducts();
});
