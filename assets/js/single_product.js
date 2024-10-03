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

