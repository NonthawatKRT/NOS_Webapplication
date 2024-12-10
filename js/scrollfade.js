/*--------------------------------------- Script For Scroll Fade Up Animation -------------------------------------------------

requirement:

     1).Add "fade-up" class to the elements you want to animate on scroll.

     2).modify the CSS to include the following:

            .fade-up {
                opacity: 0;  //Start with invisible content 
                transform: translateY(50px);  //Start slightly below the normal position 
                transition: opacity 0.8s ease-out, transform 0.8s ease-out;  //Smooth transition 
            }

            .fade-up.visible {
                opacity: 1;  //Fade in 
                transform: translateY(0);  //Move to original position 
            }

     3).Add this "<script src="js/scrollfade.js"></script>" to the bottom of the body tag in the HTML file.

-------------------------------------------------------------------------------------------------------------------------------*/

//

document.addEventListener("DOMContentLoaded", () => {
    const fadeUpElements = document.querySelectorAll(".fade-up");
    let lastScrollY = window.scrollY; // Track the last scroll position

    // Function to check and add "visible" class based on the viewport
    function checkFadeUpElements() {
        fadeUpElements.forEach((element) => {
            if (isElementInViewport(element)) {
                element.classList.add("visible");
            } else {
                element.classList.remove("visible");
            }
        });
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting && window.scrollY > lastScrollY) {
                // Add the "visible" class when scrolling down
                entry.target.classList.add("visible");
            } else if (!entry.isIntersecting && window.scrollY < lastScrollY) {
                // Remove the "visible" class only when scrolling up and the element is out of view
                entry.target.classList.remove("visible");
            }
        });

        // Update the last scroll position
        lastScrollY = window.scrollY;
    }, {
        threshold: 0.1 // Trigger when 10% of the element is visible
    });

    fadeUpElements.forEach((element) => {
        observer.observe(element);
    });

    // Helper function to check if an element is in the viewport
    function isElementInViewport(el) {
        const rect = el.getBoundingClientRect();
        return (
            rect.top <= window.innerHeight &&
            rect.bottom >= 0
        );
    }

    // Check all fade-up elements on page load and update their visibility
    checkFadeUpElements();

    // Recheck elements when scrolling
    window.addEventListener("scroll", checkFadeUpElements);

});
