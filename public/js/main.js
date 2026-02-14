document.addEventListener('DOMContentLoaded', function() {
    const navToggle = document.querySelector('.nav-toggle');
    const mainNav = document.querySelector('.main-nav');
    const header = document.getElementById('site-header');
    const scrollIndicator = document.querySelector('.scroll-indicator');
    const scrollToTop = document.querySelector('.scroll-to-top');
    const heroSection = document.querySelector('.hero');
    const heroBg = document.querySelector('.hero-bg');

    // Mobile nav toggle (hamburger to X animation)
    if (navToggle && mainNav && header) {
        navToggle.addEventListener('click', function() {
            mainNav.classList.toggle('active');
            header.classList.toggle('nav-open', mainNav.classList.contains('active'));
            navToggle.setAttribute('aria-expanded', mainNav.classList.contains('active'));
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
                if (heroSection && heroBg) {
                    var heroTop = heroSection.getBoundingClientRect().top;
                    var parallax = Math.max(-20, Math.min(40, heroTop * -0.08));
                    heroBg.style.setProperty('--hero-parallax', parallax + 'px');
                }
                ticking = false;
            });
            ticking = true;
        }
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    updateHeaderState();

    // Word-level text reveal for section titles
    function splitWords(el) {
        if (!el || el.dataset.wordsSplit === 'true') return;
        var text = (el.textContent || '').trim();
        if (!text) return;
        var words = text.split(/\s+/);
        el.textContent = '';
        words.forEach(function(word, idx) {
            var span = document.createElement('span');
            span.className = 'reveal-word';
            span.style.setProperty('--word-index', idx);
            span.textContent = word + (idx < words.length - 1 ? ' ' : '');
            el.appendChild(span);
        });
        el.dataset.wordsSplit = 'true';
    }
    document.querySelectorAll('[data-animate] .section-title').forEach(splitWords);

    // Add stagger classes to key content blocks inside each section
    function setSectionStagger(section) {
        if (!section) return;
        var idx = 0;
        section.querySelectorAll('.gather-card, .event-card-modern, .moment-item, .lights-content, .lights-image, .prayer-wall-image, .prayer-wall-content, .voice-card, .newsletter-form, .section-sub, .sermon-card, .media-card, .about-pillar, .leader-card, .brand-card, .services-card, .im-new-cta-card, .contact-item, .faq-item, .ministry-card, .job-card, .giving-option').forEach(function(el) {
            el.classList.add('stagger-item');
            el.style.setProperty('--stagger', idx++);
        });
    }

    // Scroll-in animations: add animate-in when section enters viewport
    const animatedSections = document.querySelectorAll('[data-animate]');
    animatedSections.forEach(setSectionStagger);
    const animObserver = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
                entry.target.querySelectorAll('.section-title').forEach(function(el) {
                    el.classList.add('reveal-ready');
                });
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
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
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

    // Voice (testimonial) carousel - multiple cards visible
    var voiceCarousel = document.querySelector('[data-voice-carousel]');
    if (voiceCarousel) {
        var voiceTrack = voiceCarousel.querySelector('.voice-carousel-track');
        var voiceCards = voiceCarousel.querySelectorAll('.voice-card');
        var voicePrev = voiceCarousel.querySelector('.carousel-prev');
        var voiceNext = voiceCarousel.querySelector('.voice-carousel .carousel-next');
        var voiceDots = voiceCarousel.querySelector('.voice-carousel-dots');
        voiceNext = voiceNext || voiceCarousel.querySelector('.carousel-next');

        function getVoiceCardsPerView() {
            var w = window.innerWidth;
            if (w >= 900) return 3;
            if (w >= 600) return 2;
            return 1;
        }

        var voiceIndex = 0;
        var voiceAutoTimer;

        function voiceGoTo(index) {
            var perView = getVoiceCardsPerView();
            var maxIdx = Math.max(0, voiceCards.length - perView);
            voiceIndex = Math.max(0, Math.min(maxIdx, index));
            var pct = voiceIndex * (100 / perView);
            if (voiceTrack) voiceTrack.style.transform = 'translateX(-' + pct + '%)';
            if (voiceDots) {
                voiceDots.querySelectorAll('.dot').forEach(function(d, i) {
                    d.classList.toggle('active', i === voiceIndex);
                });
            }
            voiceResetAuto();
        }

        function voiceCreateDots() {
            if (!voiceDots) return;
            voiceDots.innerHTML = '';
            var perView = getVoiceCardsPerView();
            var maxIdx = Math.max(0, voiceCards.length - perView);
            for (var i = 0; i <= maxIdx; i++) {
                var dot = document.createElement('button');
                dot.type = 'button';
                dot.className = 'dot' + (i === 0 ? ' active' : '');
                dot.setAttribute('aria-label', 'Go to testimonial set ' + (i + 1));
                dot.addEventListener('click', function() { voiceGoTo(parseInt(this.dataset.idx, 10)); });
                dot.dataset.idx = i;
                voiceDots.appendChild(dot);
            }
        }

        function voiceResetAuto() {
            clearInterval(voiceAutoTimer);
            if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches && voiceCards.length > 1) {
                voiceAutoTimer = setInterval(function() {
                    var perView = getVoiceCardsPerView();
                    var maxIdx = Math.max(0, voiceCards.length - perView);
                    voiceGoTo(voiceIndex >= maxIdx ? 0 : voiceIndex + 1);
                }, 6000);
            }
        }

        voiceCreateDots();
        if (voicePrev) voicePrev.addEventListener('click', function() { voiceGoTo(voiceIndex - 1); });
        if (voiceNext) voiceNext.addEventListener('click', function() { voiceGoTo(voiceIndex + 1); });
        voiceCarousel.addEventListener('mouseenter', function() { clearInterval(voiceAutoTimer); });
        voiceCarousel.addEventListener('mouseleave', voiceResetAuto);
        voiceResetAuto();

        var voiceTouchStart = 0, voiceTouchEnd = 0;
        voiceCarousel.addEventListener('touchstart', function(e) {
            voiceTouchStart = e.changedTouches[0].screenX;
        }, { passive: true });
        voiceCarousel.addEventListener('touchend', function(e) {
            voiceTouchEnd = e.changedTouches[0].screenX;
            var d = voiceTouchStart - voiceTouchEnd;
            if (Math.abs(d) > 50) voiceGoTo(d > 0 ? voiceIndex + 1 : voiceIndex - 1);
        }, { passive: true });

        window.addEventListener('resize', function() {
            var perView = getVoiceCardsPerView();
            var maxIdx = Math.max(0, voiceCards.length - perView);
            voiceIndex = Math.min(voiceIndex, maxIdx);
            voiceGoTo(voiceIndex);
            voiceCreateDots();
        });
    }

    // Subtle pointer pan on hero for premium depth
    if (heroSection && heroBg) {
        heroSection.addEventListener('mousemove', function(e) {
            var rect = heroSection.getBoundingClientRect();
            var x = ((e.clientX - rect.left) / rect.width - 0.5) * 12;
            heroBg.style.setProperty('--hero-pan-x', x.toFixed(2) + 'px');
        });
        heroSection.addEventListener('mouseleave', function() {
            heroBg.style.setProperty('--hero-pan-x', '0px');
        });
    }

    // Premium micro-interaction: subtle magnetic hover (desktop only)
    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (!reduceMotion && window.matchMedia('(min-width: 901px)').matches) {
        document.querySelectorAll('.brand-card').forEach(function(el) {
            el.addEventListener('mousemove', function(e) {
                var rect = el.getBoundingClientRect();
                var x = ((e.clientX - rect.left) / rect.width - 0.5) * 8;
                var y = ((e.clientY - rect.top) / rect.height - 0.5) * 8;
                el.style.transform = 'translate(' + x.toFixed(2) + 'px,' + y.toFixed(2) + 'px)';
            });
            el.addEventListener('mouseleave', function() {
                el.style.transform = '';
            });
        });
    }

    // FAQ accordion
    document.querySelectorAll('[data-faq-accordion]').forEach(function(wrapper) {
        wrapper.querySelectorAll('[data-faq-toggle]').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var item = this.closest('.faq-item');
                if (!item) return;
                var isOpen = item.classList.contains('is-open');
                wrapper.querySelectorAll('.faq-item').forEach(function(i) {
                    i.classList.remove('is-open');
                    var q = i.querySelector('[data-faq-toggle]');
                    if (q) q.setAttribute('aria-expanded', 'false');
                });
                if (!isOpen) {
                    item.classList.add('is-open');
                    var q2 = item.querySelector('[data-faq-toggle]');
                    if (q2) q2.setAttribute('aria-expanded', 'true');
                }
            });
        });
    });

    // Newsletter inline UX states (validation + success/error feedback)
    var newsletterForm = document.querySelector('.js-newsletter-form');
    if (newsletterForm) {
        var newsletterStatus = document.querySelector('.newsletter-status');
        var newsletterSubmit = newsletterForm.querySelector('.newsletter-submit');

        function setNewsletterStatus(message, state) {
            if (!newsletterStatus) return;
            newsletterStatus.textContent = message || '';
            newsletterStatus.classList.remove('success', 'error');
            if (state === 'success' || state === 'error') {
                newsletterStatus.classList.add(state);
            }
        }

        newsletterForm.addEventListener('input', function() {
            if (newsletterForm.classList.contains('is-invalid')) {
                newsletterForm.classList.remove('is-invalid');
            }
        });

        newsletterForm.addEventListener('submit', async function(e) {
            if (!newsletterForm.checkValidity()) {
                e.preventDefault();
                newsletterForm.classList.add('is-invalid');
                setNewsletterStatus('Please enter your full name and a valid email address.', 'error');
                return;
            }

            e.preventDefault();
            if (newsletterSubmit) {
                newsletterSubmit.disabled = true;
                newsletterSubmit.textContent = 'Submitting...';
            }
            setNewsletterStatus('Submitting your subscription...', '');

            try {
                var response = await fetch(newsletterForm.action, {
                    method: 'POST',
                    body: new FormData(newsletterForm),
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });

                if (!response.ok) throw new Error('Submit failed');

                newsletterForm.reset();
                newsletterForm.classList.remove('is-invalid');
                setNewsletterStatus("You're in! Check your inbox for updates.", 'success');
            } catch (err) {
                setNewsletterStatus('Could not submit automatically. Redirecting to secure submit...', '');
                newsletterForm.submit();
                return;
            } finally {
                if (newsletterSubmit) {
                    newsletterSubmit.disabled = false;
                    newsletterSubmit.textContent = 'Join Newsletter';
                }
            }
        });
    }
});
