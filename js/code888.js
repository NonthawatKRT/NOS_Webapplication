// -------------------------------------------------! Code888 System File !-------------------------------------------------

// randomColor() function
document.addEventListener('DOMContentLoaded', () => {
    console.log('Casino website loaded!');
    const adBanner = document.querySelector('.ad-banner');
    setInterval(() => {
        adBanner.style.backgroundColor = `rgb(${randomColor()}, ${randomColor()}, ${randomColor()})`;
    }, 500);
});

function randomColor() {
    return Math.floor(Math.random() * 256);
}

// showAd() and hideAd() functions
document.addEventListener('DOMContentLoaded', () => {
    // Ad Banner Color Animation
    const adBanner = document.querySelector('.ad-banner');
    setInterval(() => {
        adBanner.style.backgroundColor = `rgb(${randomColor()}, ${randomColor()}, ${randomColor()})`;
    }, 500);

    function randomColor() {
        return Math.floor(Math.random() * 256);
    }

    // Floating Ads Sliding Animation
    const ads = document.querySelectorAll('.floating-ads > div');
    const timer = 20000; // 10 seconds

    function showAd(ad) {
        ad.classList.add('active');
    }

    function hideAd(ad) {
        ad.classList.remove('active');
    }

    ads.forEach(ad => {
        // Show ad initially
        setTimeout(() => showAd(ad), 1000);

        // Auto-hide and re-show ads with a timer
        setInterval(() => {
            hideAd(ad); // Slide out
            setTimeout(() => showAd(ad), timer); // Slide back after 30 seconds
        }, timer + 5000);

        // Close button functionality
        ad.querySelector('.close-btn').addEventListener('click', () => {
            hideAd(ad); // Manually hide on click
        });
    });
});


// Smooth scrolling for navbar links and "up" arrow
document.addEventListener('DOMContentLoaded', () => {
    // Select all navbar links
    const navbarLinks = document.querySelectorAll('nav ul li a');
    // Select the "up" arrow in the footer
    const upArrow = document.querySelector('.upiconcontainer a');

    // Add smooth scrolling behavior for navbar links
    navbarLinks.forEach(link => {
        link.addEventListener('click', event => {
            const href = link.getAttribute('href');

            // Skip handling if the href points to an external page (e.g., login.php)
            if (href.startsWith('http') || href.endsWith('.php')) {
                return; // Allow default browser behavior
            }

            // Prevent default behavior
            event.preventDefault();

            // Handle "Home" link (#banner) to scroll to the top
            if (href === '#banner') {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                return;
            }

            // Otherwise, handle smooth scrolling to sections
            const targetId = href.substring(1); // Remove '#' from href
            const targetSection = document.getElementById(targetId);

            if (targetSection) {
                targetSection.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });

    // Add smooth scroll behavior for the "up" arrow
    if (upArrow) {
        upArrow.addEventListener('click', event => {
            event.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
});


//Sticky Navbar
document.addEventListener('DOMContentLoaded', () => {
    const navbar = document.querySelector('header nav'); // Select the navbar
    const initialTopOffset = navbar.offsetTop; // Capture the navbar's initial top offset

    // Handle scroll event
    function handleScroll() {
        if (window.scrollY >= initialTopOffset) {
            // Add sticky class when scrolled below initial offset
            navbar.classList.add('sticky');
        } else {
            // Remove sticky class when scrolled above initial offset
            navbar.classList.remove('sticky');
        }
    }

    // Attach the scroll event listener
    window.addEventListener('scroll', handleScroll);
});






