/*---------------------------------------------------Slide Show System File ---------------------------------------------------

Systemfile: For the slideshow on the index page
Result to : index.php

------------------------------------------------------------------------------------------------------------------------------*/

// Number of slides
const images = [
    "images/background.png",
    "images/background2.jpg",
    "images/background3.jpg",
    "images/background4.png",
    "images/background5.jpg"
];

let currentSlide = 0; // Current slide index
const slideshowWrapper = document.querySelector(".slideshow-wrapper");
const dots = document.querySelectorAll(".dot");

// Function to show a specific slide
function showSlide(index) {
    currentSlide = index;

    // Move the slideshow-wrapper
    slideshowWrapper.style.transform = `translateX(-${currentSlide * 100}%)`;

    // Update active dot
    dots.forEach((dot, i) => {
        dot.classList.toggle("active", i === currentSlide);
    });
}

// Automatically cycle through slides
function autoSlideShow() {
    currentSlide = (currentSlide + 1) % images.length; // Increment slide index
    showSlide(currentSlide); // Show the next slide
}

// Start the slideshow
let slideInterval = setInterval(autoSlideShow, 5000); // Change slide every 5 seconds

// Add event listeners for manual control
dots.forEach((dot, i) => {
    dot.addEventListener("click", () => {
        clearInterval(slideInterval); // Stop auto slideshow
        showSlide(i); // Show selected slide
        slideInterval = setInterval(autoSlideShow, 5000); // Restart slideshow
    });
});
