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
    var scrollProgress = document.querySelector('.scroll-progress');
    function onScroll() {
        if (!ticking) {
            requestAnimationFrame(function() {
                updateHeaderState();
                if (scrollToTop) scrollToTop.classList.toggle('visible', window.scrollY > 400);
                if (scrollIndicator) scrollIndicator.classList.toggle('hidden', window.scrollY > 400);
                if (scrollProgress) {
                    var docHeight = document.documentElement.scrollHeight - window.innerHeight;
                    var pct = docHeight > 0 ? Math.min(100, (window.scrollY / docHeight) * 100) : 0;
                    scrollProgress.style.transform = 'scaleX(' + (pct / 100) + ')';
                    scrollProgress.setAttribute('aria-valuenow', Math.round(pct));
                }
                ticking = false;
            });
            ticking = true;
        }
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    updateHeaderState();

    // Scroll-in animations: add animate-in when section enters viewport
    const animatedSections = document.querySelectorAll('[data-animate]');
    const animObserver = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
                animObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
    animatedSections.forEach(function(el) { animObserver.observe(el); });

    // Moments carousel
    const carousel = document.querySelector('.moments-carousel');
    if (carousel) {
        const track = carousel.querySelector('.carousel-track');
        const slides = carousel.querySelectorAll('.carousel-slide');
        const prevBtn = carousel.querySelector('.carousel-prev');
        const nextBtn = carousel.querySelector('.carousel-next');
        const dotsContainer = carousel.querySelector('.carousel-dots');
        let currentIndex = 0;
        let autoPlayTimer;
        const totalSlides = slides.length;

        function createDots() {
            if (!dotsContainer) return;
            dotsContainer.innerHTML = '';
            for (let i = 0; i < totalSlides; i++) {
                const dot = document.createElement('button');
                dot.type = 'button';
                dot.className = 'dot' + (i === 0 ? ' active' : '');
                dot.setAttribute('aria-label', 'Go to slide ' + (i + 1));
                dot.addEventListener('click', function() { goToSlide(i); });
                dotsContainer.appendChild(dot);
            }
        }
        function updateCarousel() {
            if (!track) return;
            track.style.transform = 'translateX(-' + currentIndex * 100 + '%)';
            if (dotsContainer) {
                dotsContainer.querySelectorAll('.dot').forEach(function(d, i) {
                    d.classList.toggle('active', i === currentIndex);
                });
            }
        }
        function goToSlide(index) {
            currentIndex = (index + totalSlides) % totalSlides;
            updateCarousel();
            resetAutoPlay();
        }
        function nextSlide() { goToSlide(currentIndex + 1); }
        function prevSlide() { goToSlide(currentIndex - 1); }
        function startAutoPlay() {
            autoPlayTimer = setInterval(nextSlide, 5000);
        }
        function resetAutoPlay() {
            clearInterval(autoPlayTimer);
            startAutoPlay();
        }
        createDots();
        if (prevBtn) prevBtn.addEventListener('click', prevSlide);
        if (nextBtn) nextBtn.addEventListener('click', nextSlide);
        carousel.addEventListener('mouseenter', function() { clearInterval(autoPlayTimer); });
        carousel.addEventListener('mouseleave', startAutoPlay);
        startAutoPlay();
        // Touch swipe for mobile
        let touchStartX = 0, touchEndX = 0;
        carousel.addEventListener('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });
        carousel.addEventListener('touchend', function(e) {
            touchEndX = e.changedTouches[0].screenX;
            var diff = touchStartX - touchEndX;
            if (Math.abs(diff) > 50) { diff > 0 ? nextSlide() : prevSlide(); }
        }, { passive: true });
    }
});
