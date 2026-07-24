// Import Bootstrap JavaScript
//import 'bootstrap';

// DOM Content Loaded
document.addEventListener('DOMContentLoaded', function() {

    /* ========================================
       SMOOTH SCROLLING FOR ANCHOR LINKS
    ======================================== */
    const smoothScrollLinks = document.querySelectorAll('a[href^="#"]');

    smoothScrollLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');

            // Skip if it's just "#"
            if (href === '#') {
                e.preventDefault();
                return;
            }

            const targetElement = document.querySelector(href);

            if (targetElement) {
                e.preventDefault();

                // Calculate offset to account for fixed navbar
                const navbarHeight = document.querySelector('.main-navbar').offsetHeight;
                const targetPosition = targetElement.offsetTop - navbarHeight - 20;

                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });

    /* ========================================
       SCROLL TO TOP BUTTON
    ======================================== */
    const scrollToTopBtn = document.getElementById('scrollToTop');

    if (scrollToTopBtn) {
        // Show/hide scroll to top button
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                scrollToTopBtn.classList.add('show');
            } else {
                scrollToTopBtn.classList.remove('show');
            }
        });

        // Scroll to top functionality
        scrollToTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    /* ========================================
       NAVBAR SCROLL EFFECT
    ======================================== */
    const navbar = document.querySelector('.main-navbar');

    if (navbar) {
        let lastScrollTop = 0;

        window.addEventListener('scroll', function() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            if (scrollTop > 100) {
                navbar.style.background = 'rgba(255, 255, 255, 0.95)';
                navbar.style.backdropFilter = 'blur(10px)';
            } else {
                navbar.style.background = '#ffffff';
                navbar.style.backdropFilter = 'none';
            }

            lastScrollTop = scrollTop;
        });
    }

    /* ========================================
       CAROUSEL AUTO CONTROLS
    ======================================== */
    const carousel = document.getElementById('bannerCarousel');

    if (carousel) {
        const carouselInstance = new bootstrap.Carousel(carousel, {
            interval: 10000,
            wrap: true,
            touch: true
        });

        // Custom control visibility
        const prevBtn = carousel.querySelector('.carousel-control-prev');
        const nextBtn = carousel.querySelector('.carousel-control-next');
        const indicators = carousel.querySelectorAll('.carousel-indicators button');

        // Update control visibility based on active slide
        function updateControls() {
            const activeIndex = Array.from(carousel.querySelectorAll('.carousel-item')).findIndex(item =>
                item.classList.contains('active')
            );
            const totalSlides = carousel.querySelectorAll('.carousel-item').length;

            // Show/hide controls based on slide position
            if (totalSlides <= 1) {
                prevBtn.style.display = 'none';
                nextBtn.style.display = 'none';
            } else {
                prevBtn.style.display = activeIndex === 0 ? 'none' : 'flex';
                nextBtn.style.display = activeIndex === totalSlides - 1 ? 'none' : 'flex';
            }
        }

        // Update controls on slide change
        carousel.addEventListener('slid.bs.carousel', updateControls);

        // Initial update
        updateControls();

        // Pause on hover
        carousel.addEventListener('mouseenter', function() {
            carouselInstance.pause();
        });

        carousel.addEventListener('mouseleave', function() {
            carouselInstance.cycle();
        });
    }

    /* ========================================
       FORM HANDLING
    ======================================== */
    const queryForm = document.querySelector('.query-form');

    if (queryForm) {
        queryForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Get form data
            const formData = new FormData(this);
            const formFields = this.querySelectorAll('input, textarea');
            const submitBtn = this.querySelector('button[type="submit"]');

            // Disable submit button and show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Sending...';

            // Simulate form submission (replace with actual AJAX call)
            setTimeout(() => {
                // Reset form
                this.reset();

                // Reset button
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Submit';

                // Show success message (you can customize this)
                alert('Thank you for your message! We will get back to you soon.');

                // In real implementation, you would send data to server here
                console.log('Form data:', Object.fromEntries(formData));
            }, 2000);
        });
    }

    /* ========================================
       INTERSECTION OBSERVER FOR ANIMATIONS
    ======================================== */
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe elements for animation
    const animatedElements = document.querySelectorAll('.team-card, .club-card, .feature-item');

    animatedElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'all 0.6s ease-out';
        observer.observe(el);
    });

    /* ========================================
       WHATSAPP AND EMAIL CLICK HANDLERS
    ======================================== */
    const phoneLinks = document.querySelectorAll('a[href^="https://wa.me/"]');
    const emailLinks = document.querySelectorAll('a[href^="mailto:"]');

    phoneLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Add click tracking if needed
            console.log('WhatsApp link clicked:', this.href);
        });
    });

    emailLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Add click tracking if needed
            console.log('Email link clicked:', this.href);
        });
    });

    /* ========================================
       MOBILE MENU IMPROVEMENTS
    ======================================== */
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');

    if (navbarToggler && navbarCollapse) {
        // Close mobile menu when clicking on a link
        const navLinks = navbarCollapse.querySelectorAll('.nav-link');

        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                const bsCollapse = new bootstrap.Collapse(navbarCollapse, {
                    hide: true
                });
            });
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!navbarToggler.contains(e.target) && !navbarCollapse.contains(e.target)) {
                const isExpanded = navbarToggler.getAttribute('aria-expanded') === 'true';
                if (isExpanded) {
                    const bsCollapse = new bootstrap.Collapse(navbarCollapse, {
                        hide: true
                    });
                }
            }
        });
    }

    /* ========================================
       LAZY LOADING FOR IMAGES
    ======================================== */
    const images = document.querySelectorAll('img[data-src]');

    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                imageObserver.unobserve(img);
            }
        });
    });

    images.forEach(img => imageObserver.observe(img));

    /* ========================================
       TEAM CARD HOVER EFFECTS
    ======================================== */
    const teamCards = document.querySelectorAll('.team-card');

    teamCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-15px) scale(1.02)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    /* ========================================
       CLUB CARD INTERACTIVE EFFECTS
    ======================================== */
    const clubCards = document.querySelectorAll('.club-card');

    clubCards.forEach(card => {
        const icon = card.querySelector('.club-icon');

        card.addEventListener('mouseenter', function() {
            if (icon) {
                icon.style.transform = 'scale(1.15) rotate(10deg)';
            }
        });

        card.addEventListener('mouseleave', function() {
            if (icon) {
                icon.style.transform = 'scale(1) rotate(0deg)';
            }
        });
    });

    /* ========================================
       NAVBAR ACTIVE STATE MANAGEMENT
    ======================================== */
    function updateActiveNavItem() {
        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

        let currentSection = '';

        sections.forEach(section => {
            const sectionTop = section.offsetTop - 100;
            const sectionHeight = section.offsetHeight;

            if (window.pageYOffset >= sectionTop &&
                window.pageYOffset < sectionTop + sectionHeight) {
                currentSection = section.getAttribute('id');
            }
        });

        // Remove active class from all nav links
        navLinks.forEach(link => {
            link.classList.remove('active');

            // Add active class to matching section
            if (link.getAttribute('href') === `#${currentSection}`) {
                link.classList.add('active');
            }
        });

        // Set home as active if at top of page
        if (window.pageYOffset < 100) {
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === '#' || link.textContent.trim() === 'Home') {
                    link.classList.add('active');
                }
            });
        }
    }

    // Update active nav item on scroll
    window.addEventListener('scroll', updateActiveNavItem);

    /* ========================================
       BANNER SLIDE CONTENT ANIMATIONS
    ======================================== */
    const carousel2 = document.getElementById('bannerCarousel');

    if (carousel2) {
        carousel2.addEventListener('slide.bs.carousel', function(e) {
            // Animate out current slide content
            const currentSlide = this.querySelector('.carousel-item.active .banner-content');
            if (currentSlide) {
                currentSlide.style.opacity = '0';
                currentSlide.style.transform = 'translateY(30px)';
            }
        });

        carousel2.addEventListener('slid.bs.carousel', function(e) {
            // Animate in new slide content
            const newSlide = this.querySelector('.carousel-item.active .banner-content');
            if (newSlide) {
                setTimeout(() => {
                    newSlide.style.opacity = '1';
                    newSlide.style.transform = 'translateY(0)';
                }, 100);
            }
        });
    }

    /* ========================================
       CONTACT BAR SOCIAL LINKS ANIMATION
    ======================================== */
    const socialLinks = document.querySelectorAll('.social-link');

    socialLinks.forEach((link, index) => {
        link.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px) scale(1.2) rotate(5deg)';
        });

        link.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1) rotate(0deg)';
        });

        // Stagger animation on page load
        setTimeout(() => {
            link.style.opacity = '1';
            link.style.transform = 'translateY(0)';
        }, 100 * index);
    });

    /* ========================================
       FORM VALIDATION ENHANCEMENT
    ======================================== */
    const formInputs = document.querySelectorAll('.query-form input, .query-form textarea');

    formInputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });

        input.addEventListener('blur', function() {
            if (!this.value.trim()) {
                this.parentElement.classList.remove('focused');
            }
        });

        input.addEventListener('input', function() {
            if (this.validity.valid) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
            }
        });
    });

    /* ========================================
       PERFORMANCE OPTIMIZATIONS
    ======================================== */
    let ticking = false;

    function updateScrollElements() {
        // Throttle scroll events for better performance
        if (!ticking) {
            requestAnimationFrame(() => {
                updateActiveNavItem();
                ticking = false;
            });
            ticking = true;
        }
    }

    window.addEventListener('scroll', updateScrollElements);

    /* ========================================
       ERROR HANDLING AND FALLBACKS
    ======================================== */
    window.addEventListener('error', function(e) {
        console.warn('JavaScript error caught:', e.error);
        // Add fallback behavior if needed
    });

    // Ensure all interactive elements are accessible
    const interactiveElements = document.querySelectorAll('button, a, [tabindex]');

    interactiveElements.forEach(element => {
        if (!element.hasAttribute('aria-label') && !element.textContent.trim()) {
            console.warn('Interactive element missing accessible text:', element);
        }
    });

    /* ========================================
       INITIALIZATION COMPLETE
    ======================================== */
    console.log('Actuaries of Bermuda website initialized successfully');

    // Dispatch custom event for other scripts
    document.dispatchEvent(new CustomEvent('siteInitialized', {
        detail: { timestamp: Date.now() }
    }));
});

/* ========================================
   UTILITY FUNCTIONS
======================================== */

// Debounce function for performance
function debounce(func, wait, immediate) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            timeout = null;
            if (!immediate) func(...args);
        };
        const callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func(...args);
    };
}

// Throttle function for scroll events
function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

// Check if element is in viewport
function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

// Smooth scroll to element
function smoothScrollTo(element, offset = 0) {
    const targetPosition = element.offsetTop - offset;
    window.scrollTo({
        top: targetPosition,
        behavior: 'smooth'
    });
}

// Export functions for use in other scripts if needed
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        debounce,
        throttle,
        isInViewport,
        smoothScrollTo
    };
}
