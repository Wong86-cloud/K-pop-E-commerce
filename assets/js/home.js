// Home Carousel
let currentSlideHome = 0;
const slidesHome = document.querySelectorAll('.carousel-slide');

// Make the slides visible or hidden based on the index
function showSlideHome(index) {
    slidesHome.forEach((slide, i) => {
        slide.style.display = (i === index) ? 'block' : 'none';
    });
}

function nextSlideHome() {
    currentSlideHome = (currentSlideHome + 1) % slidesHome.length; // Loop back to the first slide
    showSlideHome(currentSlideHome);
}

function prevSlideHome() {
    currentSlideHome = (currentSlideHome - 1 + slidesHome.length) % slidesHome.length; // Loop to the last slide
    showSlideHome(currentSlideHome);
}

// Initialize the home carousel by showing the first slide
showSlideHome(currentSlideHome);

// Scroll the carousel left by a fixed amount
function prevSlideArtist() {
    const carouselInner = document.querySelector('.carousel-inner');
    const scrollAmount = carouselInner.clientWidth / 3; // Scroll by 1/3 of the width of the carousel
    carouselInner.scrollLeft -= scrollAmount; // Scroll left
}

// Scroll the carousel right by a fixed amount
function nextSlideArtist() {
    const carouselInner = document.querySelector('.carousel-inner');
    const scrollAmount = carouselInner.clientWidth / 3; // Scroll by 1/3 of the width of the carousel
    carouselInner.scrollLeft += scrollAmount; // Scroll right
}
