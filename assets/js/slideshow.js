let slideIndex = 0;
const slides = document.getElementsByClassName("slide");

// Initialize slideshow
function initSlideshow() {
    if (slides.length > 0) {
        showSlides();
    }
}

// Show slides
function showSlides() {
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slideIndex++;
    if (slideIndex > slides.length) {
        slideIndex = 1;
    }
    slides[slideIndex - 1].style.display = "block";
    setTimeout(showSlides, 5000); // Change slide every 5 seconds
}

// Change slide manually
function changeSlide(n) {
    slideIndex += n - 1;
    showSlides();
}

// Start slideshow when page loads
document.addEventListener('DOMContentLoaded', initSlideshow); 