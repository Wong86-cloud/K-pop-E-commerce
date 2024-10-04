// Function to format currency
function formatCurrency(amount) {
    return `USD ${parseFloat(amount).toFixed(2)}`;
}

function addToWishlist(productId, element) {
    const heartIcon = element.querySelector('i');
    const isAdded = element.dataset.added === 'true';
    
    // Toggle between adding/removing item from wishlist
    const action = isAdded ? 'remove' : 'add';

    // Change icon color immediately for user feedback
    heartIcon.style.color = isAdded ? '#33363a' : 'red'; // Change to red if added
    element.dataset.added = !isAdded; // Update the data attribute

    // Send request to the server to add/remove from the wishlist
    fetch('server/wishlist_action.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ product_id: productId, action: action })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            alert('Failed to update wishlist: ' + (data.message || 'Unknown error.'));
            // Revert the icon color on failure
            heartIcon.style.color = isAdded ? 'red' : '#33363a'; // Revert color
            element.dataset.added = isAdded; // Revert data attribute
        }
    })
    .catch(error => {
        console.error('Error:', error);
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


// Add to cart
function addToCart(item) {
    const product = {
        name: item.closest('li').querySelector('strong').innerText,
        price: item.closest('li').querySelector('.product-price').innerText.replace('USD ', ''),
        image: item.closest('li').querySelector('img').src,
        quantity: 1
    };

    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart.push(product);
    localStorage.setItem('cart', JSON.stringify(cart));

    alert('Item added to cart');
}


document.querySelectorAll('.fas.fa-cart-plus').forEach((cartIcon) => {
    cartIcon.addEventListener('click', function () {
        addToCart(this);
    });
});
