// Home Carousel
let currentSlideHome = 0;
const slidesHome = document.querySelectorAll('.carousel-slide');

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

// Recommended Artist Carousel
function prevSlideArtist() {
    const carouselInner = document.querySelector('.carousel-inner');
    carouselInner.scrollLeft -= carouselInner.clientWidth / 3; // Scroll by a portion of the container width
}

function nextSlideArtist() {
    const carouselInner = document.querySelector('.carousel-inner');
    carouselInner.scrollLeft += carouselInner.clientWidth / 3; // Scroll by a portion of the container width
}
