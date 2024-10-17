// Constants
const CURRENCY_SYMBOL = 'USD ';
const TAX_RATE = 0.05; // Example tax rate

// Function to format currency
function formatCurrency(amount) {
    return `${CURRENCY_SYMBOL}${parseFloat(amount).toFixed(2)}`;
}

document.addEventListener("DOMContentLoaded", function () {
    const cartItemsContainer = document.getElementById('cart-items');
    const subtotalElement = document.querySelector('.subtotal-price');
    const taxElement = document.querySelector('.tax-price');
    const totalElement = document.querySelector('.total-price');

    // Function to remove item from cart in the database via an AJAX request
    async function removeFromCart(productId) {
        try {
            const response = await fetch('db_connection/remove_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ product_id: productId }),
            });
            const data = await response.json();
            if (data.success) {
                console.log("Item removed from cart successfully.");
            } else {
                console.error("Failed to remove item from cart:", data.message);
            }
        } catch (error) {
            console.error('Error removing item from cart:', error);
        }
    }

    // Function to recalculate the totals
    function updateCartTotals() {
        let subtotal = 0;

        // Loop through each cart item to update the totals
        cartItemsContainer.querySelectorAll('tr').forEach((row) => {
            console.log("Processing row:", row); // Log the entire row
            const quantityInput = row.querySelector('.quantity-input');
            const priceElement = row.querySelector('.product-price');
            const totalElement = row.querySelector('.total-price');

            console.log("Price element:", priceElement); // Log the price element

            if (priceElement) {
                const price = parseFloat(priceElement.textContent.replace(CURRENCY_SYMBOL, '').trim());
                const quantity = parseInt(quantityInput.value);
                const itemTotal = price * quantity;

                // Update item total
                if (totalElement) {
                    totalElement.textContent = formatCurrency(itemTotal);
                } else {
                    console.error("Total element not found for row:", row);
                }

                // Update subtotal
                subtotal += itemTotal;
            } else {
                console.error("Price element not found for row:", row);
            }
        });

        const tax = subtotal * TAX_RATE;
        const overallTotal = subtotal + tax;

        // Update subtotal, tax, and total in the DOM
        if (subtotalElement) {
            subtotalElement.textContent = formatCurrency(subtotal);
        } else {
            console.error("Subtotal element not found in the DOM.");
        }
        
        if (taxElement) {
            taxElement.textContent = formatCurrency(tax);
        } else {
            console.error("Tax element not found in the DOM.");
        }

        // Update hidden inputs in the checkout form
        if (document.querySelector('input[name="subtotal"]')) {
            document.querySelector('input[name="subtotal"]').value = subtotal.toFixed(2);
        } else {
            console.error("Subtotal hidden input not found in the DOM.");
        }
        
        if (document.querySelector('input[name="tax"]')) {
            document.querySelector('input[name="tax"]').value = tax.toFixed(2);
        } else {
            console.error("Tax hidden input not found in the DOM.");
        }

        if (document.querySelector('input[name="overallTotal"]')) {
            document.querySelector('input[name="overallTotal"]').value = overallTotal.toFixed(2);
        } else {
            console.error("Overall total hidden input not found in the DOM.");
        }
    }

    // Event listener for quantity changes
    cartItemsContainer.addEventListener('change', function (event) {
        if (event.target.classList.contains('quantity-input')) {
            const productId = event.target.closest('tr').getAttribute('data-id');
            const newQuantity = event.target.value;

            // Update the cart on the server (optional AJAX call)
            updateCartQuantity(productId, newQuantity)
                .then(() => updateCartTotals());
        }
    });

    // Function to update quantity in the database via an AJAX request
    async function updateCartQuantity(productId, quantity) {
        try {
            const response = await fetch('db_connection/update_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ product_id: productId, quantity: quantity }),
            });
            const data = await response.json();
            if (data.success) {
                console.log("Cart updated successfully.");
            } else {
                console.error("Failed to update cart:", data.message);
            }
        } catch (error) {
            console.error('Error updating cart:', error);
        }
    }

    // Event listener for removing items
    cartItemsContainer.addEventListener('click', function (event) {
        if (event.target.classList.contains('remove-button')) {
            const productId = event.target.closest('tr').getAttribute('data-id');

            // Remove the item from the cart on the server (optional AJAX call)
            removeFromCart(productId)
                .then(() => {
                    // Remove the item from the DOM
                    event.target.closest('tr').remove();
                    // Update the totals
                    updateCartTotals();
                });
        }
    });
});
