// Mobile menu toggle
function toggleMenu() {
    const navLinks = document.querySelector('.nav-links');
    const body = document.body;
    
    navLinks.classList.toggle('active');
    
    // Prevent scrolling when menu is open
    if (navLinks.classList.contains('active')) {
        body.style.overflow = 'hidden';
    } else {
        body.style.overflow = '';
    }
}

// Close menu when clicking outside
document.addEventListener('click', function(event) {
    const navLinks = document.querySelector('.nav-links');
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    
    if (navLinks.classList.contains('active') && 
        !navLinks.contains(event.target) && 
        !mobileMenuBtn.contains(event.target)) {
        navLinks.classList.remove('active');
        document.body.style.overflow = '';
    }
});

// Close menu when window is resized to desktop size
window.addEventListener('resize', function() {
    const navLinks = document.querySelector('.nav-links');
    if (window.innerWidth > 768 && navLinks.classList.contains('active')) {
        navLinks.classList.remove('active');
        document.body.style.overflow = '';
    }
}); 