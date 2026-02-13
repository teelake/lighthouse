document.addEventListener('DOMContentLoaded', function() {
    const navToggle = document.querySelector('.nav-toggle');
    const mainNav = document.querySelector('.main-nav');
    const header = document.getElementById('site-header');
    const scrollIndicator = document.querySelector('.scroll-indicator');
    const scrollToTop = document.querySelector('.scroll-to-top');

    // Mobile nav toggle
    if (navToggle && mainNav) {
        navToggle.addEventListener('click', function() {
            mainNav.classList.toggle('active');
        });
    }

    // Dropdown toggles on mobile
    document.querySelectorAll('.has-dropdown > a').forEach(function(link) {
        link.addEventListener('click', function(e) {
            if (window.innerWidth <= 900) {
                e.preventDefault();
                const ul = this.nextElementSibling;
                if (ul) ul.style.display = ul.style.display === 'block' ? 'none' : 'block';
            }
        });
    });

    // Header scroll effect: white bg + black logo when scrolled
    function updateHeaderState() {
        if (!header) return;
        const scrolled = window.scrollY > 80;
        header.classList.toggle('header-scrolled', scrolled);
    }

    // Scroll indicator: click to scroll down to first section
    if (scrollIndicator) {
        scrollIndicator.addEventListener('click', function() {
            const firstSection = document.querySelector('.gather-section, .section');
            if (firstSection) {
                firstSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
        scrollIndicator.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                scrollIndicator.click();
            }
        });
    }

    // Scroll to top: show when scrolled, click scrolls up
    if (scrollToTop) {
        scrollToTop.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // Throttled scroll handler
    let ticking = false;
    function onScroll() {
        if (!ticking) {
            requestAnimationFrame(function() {
                updateHeaderState();
                if (scrollToTop) scrollToTop.classList.toggle('visible', window.scrollY > 400);
                if (scrollIndicator) scrollIndicator.classList.toggle('hidden', window.scrollY > 400);
                ticking = false;
            });
            ticking = true;
        }
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    updateHeaderState();
});
