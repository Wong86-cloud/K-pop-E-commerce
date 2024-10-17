var mainImg = document.getElementById("main-img");
var smallImgs = document.querySelectorAll(".small-img");

var productTitle = document.getElementById("product-title");
var productPrice = document.getElementById("product-price");
var productDetails = document.getElementById("product-details");

smallImgs.forEach(img => {
    img.addEventListener('click', function() {
        // Change the main image
        mainImg.src = this.src;
        mainImg.alt = this.getAttribute('data-title'); // Update alt text
        
        // Update product info
        productTitle.innerText = this.getAttribute('data-title');
        productPrice.innerText = this.getAttribute('data-price');
        productDetails.innerText = this.getAttribute('data-details');
    });
});

// Add to cart
function addToCart(productId) {
    const quantity = document.getElementById("quantity-" + productId).value; // Get quantity
    const formData = new FormData();
    formData.append('product_id', productId);
    formData.append('quantity', quantity); // Include quantity

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
        } else {
            alert('Error adding product to cart');
        }
    })
    .catch(error => console.error('Error:', error));
}
