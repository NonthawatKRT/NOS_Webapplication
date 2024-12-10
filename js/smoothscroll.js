/*--------------------------------------- Smooth scroll For Navbar Links and "Up" Arrow -------------------------------------

requirement:
    
        1). Add this "<script src="js/smoothscroll.js"></script>" to the bottom of the body tag in the HTML file.

-------------------------------------------------------------------------------------------------------------------------------*/

// Easing function for smooth scroll
function easeInOutQuad(t) {
    return t < 0.5 ? 2 * t * t : -1 + (4 - 2 * t) * t;
}

// Smooth scroll function
function smoothScrollTo(targetPosition, duration) {
    const startPosition = window.scrollY;
    const distance = targetPosition - startPosition;
    let startTime = null;

    function animation(currentTime) {
        if (!startTime) startTime = currentTime;
        const timeElapsed = currentTime - startTime;
        const progress = Math.min(timeElapsed / duration, 1); // Ensure progress doesn't exceed 1
        const easing = easeInOutQuad(progress);

        window.scrollTo(0, startPosition + distance * easing);

        if (progress < 1) requestAnimationFrame(animation);
    }

    requestAnimationFrame(animation);
}

// Scroll to footer when "ABOUT US" is clicked
document.querySelector('.nav-links li:last-child a').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent default anchor behavior
    const footer = document.querySelector('.footer');
    smoothScrollTo(footer.offsetTop, 1200); // 1000ms (1 second) duration
});

// Scroll to top when arrow icon is clicked
document.querySelector('.upiconcontainer a').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent default anchor behavior
    smoothScrollTo(0, 1200); // 1000ms (1 second) duration
});