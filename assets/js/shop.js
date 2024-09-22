// Function to format currency
function formatCurrency(amount) {
    return `USD ${parseFloat(amount).toFixed(2)}`;
}

// Toggle like button color
function likeButton(button) {
    if (button.style.color === "red") {
        button.style.color = "#33363a"; // Default color
    } else {
        button.style.color = "red";
    }
}

// Add to wishlist
function addToWishlist(item) {
    const product = {
        name: item.closest('li').querySelector('strong').innerText,
        price: item.closest('li').querySelector('.product-price').innerText.replace('USD ', ''),
        image: item.closest('li').querySelector('img').src,
        category: item.closest('li').dataset.category
    };

    let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
    wishlist.push(product);
    localStorage.setItem('wishlist', JSON.stringify(wishlist));

    alert('Item added to wishlist');
}

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

// Attach event listeners
document.querySelectorAll('.fas.fa-heart').forEach((heartIcon) => {
    heartIcon.addEventListener('click', function () {
        likeButton(this);
        addToWishlist(this);
    });
});

document.querySelectorAll('.fas.fa-cart-plus').forEach((cartIcon) => {
    cartIcon.addEventListener('click', function () {
        addToCart(this);
    });
});
