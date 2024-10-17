// Function to format currency
function formatCurrency(amount) {
    const number = parseFloat(amount);
    return isNaN(number) ? 'USD 0.00' : `USD ${number.toFixed(2)}`;
}

function toggleLike(button) {
    const wishlistContainer = document.querySelector('.wishlist-items');
    const heartIcon = button.firstElementChild;
    const productId = button.closest('li').dataset.productId; // Get the product_id

    // Check the current color to determine the action
    if (heartIcon.style.color === "red") {
        heartIcon.style.color = "#33363a"; // Set to default color

        // Send request to remove the item from the database
        fetch('db_connection/wishlist_action.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ product_id: productId, action: 'remove' })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the item from the UI
                const itemToRemove = wishlistContainer.querySelector(`li[data-product-id="${productId}"]`);
                if (itemToRemove) {
                    wishlistContainer.removeChild(itemToRemove); // Remove the item from the DOM
                    alert('Product successfully removed from the cart.');
                }
            } else {
                alert('Failed to remove item from wishlist: ' + (data.message || 'Unknown error.'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while trying to remove the item from the wishlist.');
        });
    } else {
        heartIcon.style.color = "red"; // Change color to red to indicate it's added (optional)
        // Logic for adding back the item can be added here if necessary
    }
}

//Add to cart
function addToCart(productId, quantity = 1) {
    const formData = new FormData();
    formData.append('product_id', productId);
    formData.append('quantity', quantity);  

    fetch('db_connection/add_to_cart.php', {
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
