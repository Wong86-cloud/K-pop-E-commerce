// Function to format currency
function formatCurrency(amount) {
    return `USD ${parseFloat(amount).toFixed(2)}`;
}

// Function to load cart items from localStorage and display them
function loadCart() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartContainer = document.getElementById('cart-items');
    cartContainer.innerHTML = ''; // Clear previous items

    let totalPrice = 0;

    cart.forEach(item => {
        const itemTotal = item.quantity * parseFloat(item.price);
        totalPrice += itemTotal;

        cartContainer.innerHTML += `
            <tr data-id="${item.id}">
                <td>
                    <div class="cart-info">
                        <img src="${item.image}" alt="${item.name}">
                        <div>
                            <p>${item.name}</p>
                            <small class="product-price">${formatCurrency(item.price)}</small>
                        </div>
                    </div>
                </td>
                <td>
                    <input type="number" value="${item.quantity}" min="1" class="quantity-input">
                    <a class="remove-button" href="#" onclick="removeFromCart('${item.id}'); return false;">Remove</a>
                </td>
                <td><span class="product-price">${formatCurrency(item.price)}</span></td>
                <td><span class="total-price">${formatCurrency(itemTotal)}</span></td>
            </tr>
        `;
    });

    // Update total price in the footer
    document.querySelector('.subtotal-price').innerText = formatCurrency(totalPrice);
    document.querySelector('.total-price').innerText = formatCurrency(totalPrice);
}

// Function to remove an item from the cart
function removeFromCart(itemId) {
    console.log(`Attempting to remove item with id: ${itemId}`); // Debugging line

    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    console.log(`Cart before removal: ${JSON.stringify(cart)}`); // Debugging line

    cart = cart.filter(item => item.id !== itemId);
    console.log(`Cart after removal: ${JSON.stringify(cart)}`); // Debugging line

    localStorage.setItem('cart', JSON.stringify(cart));
    loadCart(); // Reload the cart to reflect changes
}

// Event listener for quantity change
document.addEventListener('change', function (e) {
    if (e.target.classList.contains('quantity-input')) {
        const row = e.target.closest('tr');
        const itemId = row.getAttribute('data-id');
        const newQuantity = parseInt(e.target.value, 10);

        // Ensure newQuantity is a valid number
        if (isNaN(newQuantity) || newQuantity <= 0) {
            e.target.value = 1; // Reset to 1 if invalid
            return;
        }

        console.log(`Updating quantity for item with id: ${itemId} to ${newQuantity}`); // Debugging line

        // Update quantity in localStorage
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        cart = cart.map(item => {
            if (item.id === itemId) {
                item.quantity = newQuantity;
            }
            return item;
        });
        localStorage.setItem('cart', JSON.stringify(cart));

        // Update total price
        loadCart(); // Reload the cart to reflect changes
    }
});

// Call loadCart function when the page loads
window.onload = loadCart;
