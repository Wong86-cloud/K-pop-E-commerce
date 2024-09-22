// Function to format currency
function formatCurrency(amount) {
    const number = parseFloat(amount);
    return isNaN(number) ? 'USD 0.00' : `USD ${number.toFixed(2)}`;
}

// Load wishlist from localStorage
function loadWishlist() {
    const wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
    const wishlistContainer = document.querySelector('.wishlist-items');
    wishlistContainer.innerHTML = ''; // Clear previous items

    wishlist.forEach((item, index) => {
        const formattedPrice = formatCurrency(item.price);
        wishlistContainer.innerHTML += `
            <li data-category="${item.category}">
                <picture>
                    <img src="${item.image}" alt="${item.name}">
                </picture>
                <div class="item-description">
                    <div class="icon">
                        <span onclick="toggleLike(this, ${index})">
                            <i class="fas fa-heart" style="color:red"></i>
                        </span>
                        <span onclick="addToCart(${index})">
                            <i class="fas fa-cart-plus"></i>
                        </span>
                    </div>
                    <strong>${item.name}</strong>
                    <span class="product-price">${formattedPrice}</span>
                    <small>Buy Now</small>
                </div>
            </li>
        `;
    });
}

// Function to toggle the heart icon color and remove from wishlist
function toggleLike(button, index) {
    const wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
    
    // Toggle heart color
    const heartIcon = button.firstElementChild;
    if (heartIcon.style.color === "red") {
        heartIcon.style.color = "#33363a"; // Default color
    } else {
        heartIcon.style.color = "red";
    }

    // Remove item from wishlist when heart is unliked
    if (heartIcon.style.color !== "red") {
        wishlist.splice(index, 1); // Remove the item from wishlist
        localStorage.setItem('wishlist', JSON.stringify(wishlist));
        loadWishlist(); // Reload wishlist
    }
}

// Function to add item to cart
function addToCart(index) {
    const wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    // Add the item to cart
    cart.push(wishlist[index]);
    localStorage.setItem('cart', JSON.stringify(cart));

    // Optionally, remove the item from wishlist after adding to cart
    wishlist.splice(index, 1);
    localStorage.setItem('wishlist', JSON.stringify(wishlist));

    loadWishlist(); // Reload wishlist
}

// Call loadWishlist when the page loads
window.onload = loadWishlist;
