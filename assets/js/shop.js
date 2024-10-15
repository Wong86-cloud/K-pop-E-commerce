// Function to format currency
function formatCurrency(amount) {
    return `USD ${parseFloat(amount).toFixed(2)}`;
}

// Search Product
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

//Filter Price
document.addEventListener('DOMContentLoaded', function() {
    const filterProductCheckboxes = document.querySelectorAll('input[type="checkbox"][name="filter"]');
    const filterPriceRadios = document.querySelectorAll('input[type="radio"][name="price_order"]');
    const productItems = document.querySelectorAll('.shop-items li');
    const searchBox = document.getElementById('search_box');
    const searchButton = document.getElementById('search_button');

    // Define shopItemsContainer at this level for wider access
    const shopItemsContainer = document.querySelector('.shop-items'); // Adjust the selector to your actual container

    function filterProducts() {
        let selectedCategories = [];
        let selectedPriceFilter = 'Default';
        const searchQuery = searchBox.value.toLowerCase().trim();

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
            const productName = item.querySelector('strong').textContent.toLowerCase();

            const matchesCategory = selectedCategories.includes('all') || selectedCategories.includes(category);
            const matchesSearch = productName.includes(searchQuery);

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

        // Clear the current shop items container and append sorted items
        shopItemsContainer.innerHTML = '';
        sortedItems.forEach(item => {
            shopItemsContainer.appendChild(item);
        });
    }

    // Add event listeners to checkboxes, radio buttons, and search box
    filterProductCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', filterProducts);
    });
    filterPriceRadios.forEach(radio => {
        radio.addEventListener('change', filterProducts);
    });

    // Listen for search input changes or button click to trigger filtering
    searchBox.addEventListener('input', filterProducts);
    searchButton.addEventListener('click', filterProducts);

    // Initial filter
    filterProducts();
});

function addToWishlist(productId, element) {
    const heartIcon = element.querySelector('i');
    const isAdded = element.dataset.added === 'true';
    
    // Toggle between adding/removing item from wishlist
    const action = isAdded ? 'remove' : 'add';

    // Change icon color immediately for user feedback
    heartIcon.style.color = isAdded ? '#33363a' : 'red'; // Change to red if added
    element.dataset.added = !isAdded; // Update the data attribute

    // Send request to the server to add/remove from the wishlist
    fetch('db_connection/wishlist_action.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ product_id: productId, action: action })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success alert based on the action
            const actionText = action === 'add' ? 'added to' : 'removed from';
            alert(`Product has been successfully ${actionText} your wishlist!`);
        } else {
            alert('Failed to update wishlist: ' + (data.message || 'Unknown error.'));
            // Revert the icon color on failure
            heartIcon.style.color = isAdded ? 'red' : '#33363a'; // Revert color
            element.dataset.added = isAdded; // Revert data attribute
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating your wishlist. Please try again.');
        // Revert the icon color on error
        heartIcon.style.color = isAdded ? 'red' : '#33363a'; // Revert color
        element.dataset.added = isAdded; // Revert data attribute
    });
}

// Attach event listeners
document.querySelectorAll('.fas.fa-heart').forEach((heartIcon) => {
    heartIcon.addEventListener('click', function () {
        addToWishlist(this.closest('li').getAttribute('data-product-id'), this.parentElement);
    });
});

//Add to cart
function addToCart(productId, quantity = 1) {
    const formData = new FormData();
    formData.append('product_id', productId);
    formData.append('quantity', quantity);  

    fetch('db_connection/cart/add_to_cart.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'added') {
            alert('Product added to cart');
        } else if (data.status === 'exists') {
            alert('Product is already in the cart');
        } else if (data.status === 'not_logged_in') {
            alert('Please log in to add items to the cart');
        }
    })
    .catch(error => console.error('Error:', error));
}

document.querySelectorAll('.fas.fa-cart-plus').forEach((cartIcon) => {
    cartIcon.addEventListener('click', function () {
        addToCart(this);
    });
});
