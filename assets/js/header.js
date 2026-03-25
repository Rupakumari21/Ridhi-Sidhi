document.addEventListener("DOMContentLoaded", function () {
    /* ===============================
       LOAD HEADER HTML
    ================================ */
    fetch("header.html")
        .then(response => {
            if (!response.ok) throw new Error("Header file not found");
            return response.text();
        })
        .then(html => {
            document.getElementById("header").innerHTML = html;

            setActiveMenu();
            initMobileMenu();
            initScrollHeader();
        })
        .catch(err => console.error(err));

    /* ===============================
       ACTIVE MENU HIGHLIGHT
       (NOW INCLUDES DROPDOWN PAGES)
    ================================ */
    function setActiveMenu() {
        const currentPage = window.location.pathname.split("/").pop();
        
        // Define service dropdown pages
        const servicePages = [
            "security-guard-services.html",
            "manpower-supply.html",
            "facility-management.html",
            "housekeeping-services.html",
            "corporate-security.html",
            "educational-security.html",
            "government-security.html"
        ];
        
        // Define supply dropdown pages
        const supplyPages = [
            "supply-stationery.html",
            "supply-cleaning.html",
            "supply-security-items.html",
            "supply-equipments.html"
        ];

        // Find all navbar links
        document.querySelectorAll(".navbar a").forEach(link => {
            const linkPage = link.getAttribute("href");
            
            // Direct match
            if (linkPage === currentPage) {
                link.classList.add("active");
                activateParentDropdown(link);
            }
            
            // Check if current page is in service dropdown
            else if (servicePages.includes(currentPage) && linkPage === "services.html") {
                link.classList.add("active");
                activateParentDropdown(link);
            }
            
            // Check if current page is in supply dropdown
            else if (supplyPages.includes(currentPage) && linkPage === "supply.html") {
                link.classList.add("active");
                activateParentDropdown(link);
            }
            
            // Also highlight dropdown item itself
            if (linkPage === currentPage) {
                link.classList.add("active");
            }
        });
        
        // Function to activate parent dropdown
        function activateParentDropdown(link) {
            const parentDropdown = link.closest(".dropdown");
            if (parentDropdown) {
                parentDropdown.classList.add("active");
                const dropdownToggle = parentDropdown.querySelector(".dropdown-toggle");
                if (dropdownToggle) {
                    dropdownToggle.classList.add("active");
                }
            }
        }
    }

    /* ===============================
       MOBILE MENU + DROPDOWN FIX
    ================================ */
    function initMobileMenu() {
        const menuBtn = document.querySelector(".mobile-menu-btn");
        const navMenu = document.querySelector(".navbar ul");
        const dropdownToggles = document.querySelectorAll("[data-dropdown]");
        const dropdowns = document.querySelectorAll(".dropdown");
        const normalLinks = document.querySelectorAll(".navbar a:not([data-dropdown])");
        
        let scrollPosition = 0;

        /* Toggle main mobile menu */
        menuBtn.addEventListener("click", () => {
            const isMenuOpen = navMenu.classList.contains("show");
            
            if (!isMenuOpen) {
                // OPEN MENU - Prevent background scrolling
                scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
                document.body.classList.add("no-scroll");
                document.body.style.top = `-${scrollPosition}px`;
                navMenu.classList.add("show");
            } else {
                // CLOSE MENU - Restore scrolling
                document.body.classList.remove("no-scroll");
                document.body.style.top = '';
                window.scrollTo(0, scrollPosition);
                navMenu.classList.remove("show");
                
                // Close all dropdowns when closing main menu
                dropdowns.forEach(drop => {
                    drop.classList.remove("open");
                });
            }
        });

        /* Mobile dropdown toggle */
        dropdownToggles.forEach(toggle => {
            toggle.addEventListener("click", (e) => {
                // Only for mobile
                if (window.innerWidth > 992) return;
                
                e.preventDefault();
                e.stopPropagation();
                
                const parentDropdown = toggle.closest(".dropdown");
                parentDropdown.classList.toggle("open");
                
                // Close other dropdowns if open
                dropdowns.forEach(drop => {
                    if (drop !== parentDropdown) {
                        drop.classList.remove("open");
                    }
                });
            });
        });

        /* Close menu when clicking regular links */
        normalLinks.forEach(link => {
            link.addEventListener("click", () => {
                if (window.innerWidth <= 992) {
                    document.body.classList.remove("no-scroll");
                    document.body.style.top = '';
                    window.scrollTo(0, scrollPosition);
                    navMenu.classList.remove("show");
                }
            });
        });

        /* Close dropdowns when clicking outside on mobile */
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 768) {
                const isClickInsideDropdown = e.target.closest('.dropdown') || 
                                             e.target.closest('.dropdown-toggle') ||
                                             e.target.closest('.dropdown-menu');
                
                if (navMenu.classList.contains('show') && !isClickInsideDropdown) {
                    dropdowns.forEach(drop => {
                        drop.classList.remove("open");
                    });
                }
                
                if (navMenu.classList.contains('show') && 
                    !e.target.closest('.navbar') && 
                    !e.target.closest('.mobile-menu-btn')) {
                    
                    document.body.classList.remove("no-scroll");
                    document.body.style.top = '';
                    window.scrollTo(0, scrollPosition);
                    navMenu.classList.remove("show");
                }
            }
        });

        /* Close everything on window resize to desktop */
        window.addEventListener('resize', () => {
            if (window.innerWidth > 992) {
                document.body.classList.remove("no-scroll");
                document.body.style.top = '';
                navMenu.classList.remove("show");
                dropdowns.forEach(drop => {
                    drop.classList.remove("open");
                });
            }
        });

        /* Close only dropdowns when clicking dropdown links */
        document.querySelectorAll('.dropdown-menu a').forEach(dropdownLink => {
            dropdownLink.addEventListener('click', (e) => {
                if (window.innerWidth <= 992) {
                    // Optional: Close the dropdown after clicking a link
                    // const parentDropdown = dropdownLink.closest('.dropdown');
                    // parentDropdown.classList.remove('open');
                }
            });
        });
    }

    /* ===============================
       STICKY HEADER SCROLL EFFECT
    ================================ */
    function initScrollHeader() {
        window.addEventListener("scroll", () => {
            const header = document.querySelector(".header");
            if (!header) return;

            if (window.scrollY > 80) {
                header.classList.add("scrolled");
            } else {
                header.classList.remove("scrolled");
            }
        });
    }
});