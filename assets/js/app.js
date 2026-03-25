// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Preloader
    window.addEventListener('load', function() {
        const preloader = document.querySelector('.preloader');
        if (preloader) {
            preloader.style.opacity = '0';
            preloader.style.visibility = 'hidden';
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 500);
        }
    });

    // Mobile Menu Toggle
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const navbar = document.querySelector('.navbar ul');
    
    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            navbar.classList.toggle('active');
            this.classList.toggle('active');
        });
    }
    
    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.navbar') && !event.target.closest('.mobile-menu-btn')) {
            navbar.classList.remove('active');
            if (mobileMenuBtn) mobileMenuBtn.classList.remove('active');
        }
    });
    
    // Close mobile menu when clicking a link
    document.querySelectorAll('.navbar a').forEach(link => {
        link.addEventListener('click', () => {
            navbar.classList.remove('active');
            if (mobileMenuBtn) mobileMenuBtn.classList.remove('active');
        });
    });

    // Header scroll effect
    const header = document.querySelector('.header');
    window.addEventListener('scroll', function() {
        if (window.scrollY > 100) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    // Back to Top Button
    const backToTopBtn = document.querySelector('.back-to-top');
    if (backToTopBtn) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                backToTopBtn.classList.add('visible');
            } else {
                backToTopBtn.classList.remove('visible');
            }
        });

        backToTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // Animate elements on scroll
    const animateOnScroll = function() {
        const elements = document.querySelectorAll('.service-card, .client-card, .cert-card');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        });

        elements.forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });
    };

    // Initialize animations
    animateOnScroll();

    // Stats counter animation
    const statNumbers = document.querySelectorAll('.stat-number');
    if (statNumbers.length > 0) {
        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    statNumbers.forEach(stat => {
                        animateCounter(stat);
                    });
                    statsObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        statsObserver.observe(document.querySelector('.hero-stats'));
    }

    function animateCounter(element) {
        const targetText = element.textContent;
        const hasPlus = targetText.includes('+');
        const target = parseInt(targetText.replace('+', ''));
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;
        
        const timer = setInterval(() => {
            current += step;
            if (current >= target) {
                element.textContent = target + (hasPlus ? '+' : '');
                clearInterval(timer);
                
                // Add pulse animation
                element.classList.add('pulse');
                setTimeout(() => {
                    element.classList.remove('pulse');
                }, 300);
            } else {
                element.textContent = Math.floor(current) + (hasPlus ? '+' : '');
            }
        }, 16);
    }

    // Add pulse animation style
    const style = document.createElement('style');
    style.textContent = `
        .pulse {
            animation: pulse 0.3s ease;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
    `;
    document.head.appendChild(style);

    // Service card hover effect enhancement
    const serviceCards = document.querySelectorAll('.service-card');
    serviceCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            const icon = this.querySelector('.service-icon');
            if (icon) {
                icon.style.transform = 'scale(1.1) rotate(5deg)';
            }
        });
        
        card.addEventListener('mouseleave', function() {
            const icon = this.querySelector('.service-icon');
            if (icon) {
                icon.style.transform = 'scale(1) rotate(0deg)';
            }
        });
    });

    // Contact form handling (for contact.html)
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form values
            const name = document.getElementById('name').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const service = document.getElementById('service').value;
            const location = document.getElementById('location').value.trim();
            const message = document.getElementById('message').value.trim();
            
            // Simple validation
            if (!name || !phone || !service || !location || !message) {
                showFormMessage('Please fill in all required fields.', 'error');
                return;
            }
            
            // Phone number validation
            const phoneRegex = /^[0-9]{10}$/;
            const cleanPhone = phone.replace(/\D/g, '');
            if (!phoneRegex.test(cleanPhone)) {
                showFormMessage('Please enter a valid 10-digit phone number.', 'error');
                return;
            }
            
            // Show success message
            showFormMessage('Thank you for your message! We will contact you shortly.', 'success');
            
            // Reset form
            contactForm.reset();
        });
    }

    // Function to show form messages
    function showFormMessage(text, type) {
        const formMessage = document.getElementById('formMessage');
        if (!formMessage) return;
        
        formMessage.textContent = text;
        formMessage.className = 'form-message ' + type;
        formMessage.style.display = 'block';
        
        // Hide message after 5 seconds
        setTimeout(() => {
            formMessage.style.opacity = '0';
            formMessage.style.transform = 'translateY(-10px)';
            setTimeout(() => {
                formMessage.style.display = 'none';
                formMessage.style.opacity = '1';
                formMessage.style.transform = 'translateY(0)';
            }, 300);
        }, 5000);
    }

    // Add smooth scrolling for all anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            // Check if it's an internal link
            if (href !== '#' && href.startsWith('#')) {
                e.preventDefault();
                const targetElement = document.querySelector(href);
                
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                    
                    // Update URL without page reload
                    history.pushState(null, null, href);
                }
            }
        });
    });

    // Parallax effect for hero section
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const hero = document.querySelector('.hero');
        
        if (hero) {
            hero.style.backgroundPositionY = scrolled * 0.5 + 'px';
        }
    });

    // Initialize tooltips for contact icons
    const contactIcons = document.querySelectorAll('.contact-info i, .social-icon');
    contactIcons.forEach(icon => {
        icon.addEventListener('mouseenter', function() {
            const parent = this.parentElement;
            if (parent.title) {
                // Create tooltip
                const tooltip = document.createElement('div');
                tooltip.className = 'tooltip';
                tooltip.textContent = parent.title;
                document.body.appendChild(tooltip);
                
                const rect = parent.getBoundingClientRect();
                tooltip.style.left = rect.left + rect.width / 2 - tooltip.offsetWidth / 2 + 'px';
                tooltip.style.top = rect.top - tooltip.offsetHeight - 10 + 'px';
                
                // Remove tooltip on mouse leave
                parent.addEventListener('mouseleave', function() {
                    if (tooltip.parentElement) {
                        tooltip.parentElement.removeChild(tooltip);
                    }
                }, { once: true });
            }
        });
    });

    // Add CSS for tooltips
    const tooltipStyle = document.createElement('style');
    tooltipStyle.textContent = `
        .tooltip {
            position: fixed;
            background: var(--gold);
            color: var(--black);
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 600;
            z-index: 9999;
            pointer-events: none;
            transform: translateY(10px);
            opacity: 0;
            animation: tooltipFadeIn 0.3s ease forwards;
        }
        
        @keyframes tooltipFadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    `;
    document.head.appendChild(tooltipStyle);

    // Initialize when page is fully loaded
    window.dispatchEvent(new Event('scroll'));
});

// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Preloader
    window.addEventListener('load', function() {
        const preloader = document.querySelector('.preloader');
        if (preloader) {
            preloader.style.opacity = '0';
            preloader.style.visibility = 'hidden';
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 500);
        }
    });

    // Mobile Menu Toggle
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const navbar = document.querySelector('.navbar ul');
    
    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            navbar.classList.toggle('active');
            this.classList.toggle('active');
        });
    }
    
    // Mobile Dropdown Toggle
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            if (window.innerWidth <= 768) {
                e.preventDefault();
                e.stopPropagation();
                const dropdown = this.parentElement;
                dropdown.classList.toggle('active');
                
                // Close other dropdowns
                dropdownToggles.forEach(otherToggle => {
                    if (otherToggle !== this) {
                        const otherDropdown = otherToggle.parentElement;
                        otherDropdown.classList.remove('active');
                    }
                });
            }
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        // Close mobile menu when clicking outside
        if (!event.target.closest('.navbar') && !event.target.closest('.mobile-menu-btn')) {
            navbar.classList.remove('active');
            if (mobileMenuBtn) mobileMenuBtn.classList.remove('active');
            
            // Close all dropdowns on mobile
            if (window.innerWidth <= 768) {
                dropdownToggles.forEach(toggle => {
                    const dropdown = toggle.parentElement;
                    dropdown.classList.remove('active');
                });
            }
        }
        
        // Close dropdowns on desktop when clicking elsewhere
        if (window.innerWidth > 768) {
            if (!event.target.closest('.dropdown')) {
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.style.opacity = '0';
                    menu.style.visibility = 'hidden';
                    menu.style.transform = 'translateY(10px)';
                });
            }
        }
    });
    
    // Close mobile menu when clicking a link
    document.querySelectorAll('.navbar a:not(.dropdown-toggle)').forEach(link => {
        link.addEventListener('click', () => {
            navbar.classList.remove('active');
            if (mobileMenuBtn) mobileMenuBtn.classList.remove('active');
            
            // Close all dropdowns on mobile
            if (window.innerWidth <= 768) {
                dropdownToggles.forEach(toggle => {
                    const dropdown = toggle.parentElement;
                    dropdown.classList.remove('active');
                });
            }
        });
    });

    // Header scroll effect
    const header = document.querySelector('.header');
    window.addEventListener('scroll', function() {
        if (window.scrollY > 100) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    // Smooth scrolling for anchor links in dropdown
    document.querySelectorAll('.dropdown-menu a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            // Check if it's an anchor link to a section
            if (href.startsWith('#') && href !== '#') {
                e.preventDefault();
                const targetElement = document.querySelector(href);
                
                if (targetElement) {
                    // Close mobile menu
                    if (window.innerWidth <= 768) {
                        navbar.classList.remove('active');
                        if (mobileMenuBtn) mobileMenuBtn.classList.remove('active');
                    }
                    
                    // Scroll to section
                    window.scrollTo({
                        top: targetElement.offsetTop - 100,
                        behavior: 'smooth'
                    });
                    
                    // Update URL
                    history.pushState(null, null, href);
                }
            }
        });
    });

});

/* ==============================
   PREMIUM MOBILE MENU
============================== */

const menuBtn = document.querySelector(".mobile-menu-btn");
const navMenu = document.querySelector(".navbar ul");
const overlay = document.querySelector(".mobile-nav-overlay");
const dropdowns = document.querySelectorAll(".dropdown");

menuBtn.addEventListener("click", () => {
    navMenu.classList.toggle("active");
    overlay.classList.toggle("active");

    const icon = menuBtn.querySelector("i");
    icon.classList.toggle("fa-bars");
    icon.classList.toggle("fa-xmark");
});

overlay.addEventListener("click", () => {
    navMenu.classList.remove("active");
    overlay.classList.remove("active");

    const icon = menuBtn.querySelector("i");
    icon.classList.add("fa-bars");
    icon.classList.remove("fa-xmark");
});

/* Accordion dropdowns */
dropdowns.forEach(dropdown => {
    const toggle = dropdown.querySelector(".dropdown-toggle");

    toggle.addEventListener("click", (e) => {
        if (window.innerWidth <= 992) {
            e.preventDefault();
            dropdown.classList.toggle("active");
        }
    });
});

