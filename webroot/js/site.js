// Mobile navigation toggle for the public site header.
(function () {
    var header = document.querySelector('.site-header');
    var hero = document.querySelector('section.hero, #home');
    var toggle = document.querySelector('.nav-toggle');
    var nav = document.getElementById('site-nav');

    function syncHeaderState() {
        if (!header || !hero) {
            return;
        }

        var headerHeight = header.offsetHeight || 0;
        var heroBottom = hero.offsetTop + hero.offsetHeight - headerHeight;
        var isOverHero = window.scrollY < heroBottom;
        header.classList.toggle('is-over-hero', isOverHero);
    }

    syncHeaderState();
    window.addEventListener('scroll', syncHeaderState, { passive: true });
    window.addEventListener('resize', syncHeaderState);

    if (!toggle || !nav) {
        return;
    }

    toggle.addEventListener('click', function () {
        var open = nav.classList.toggle('open');
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        toggle.textContent = open ? '✕' : '☰';
        header.classList.toggle('has-mobile-menu-open', open);
    });

    nav.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', function () {
            nav.classList.remove('open');
            toggle.setAttribute('aria-expanded', 'false');
            toggle.textContent = '☰';
            header.classList.remove('has-mobile-menu-open');
        });
    });
})();

(function () {
    var galleryItems = Array.prototype.slice.call(document.querySelectorAll('[data-gallery-trigger]'));
    var lightbox = document.querySelector('[data-gallery-lightbox]');

    if (!galleryItems.length || !lightbox) {
        return;
    }

    var image = lightbox.querySelector('[data-gallery-image]');
    var caption = lightbox.querySelector('[data-gallery-caption]');
    var closeButton = lightbox.querySelector('[data-gallery-close]');
    var prevButton = lightbox.querySelector('[data-gallery-prev]');
    var nextButton = lightbox.querySelector('[data-gallery-next]');
    var activeIndex = 0;

    function renderImage(index) {
        var trigger = galleryItems[index];

        if (!trigger || !image || !caption) {
            return;
        }

        activeIndex = index;
        image.src = trigger.getAttribute('data-gallery-src') || '';
        image.alt = trigger.getAttribute('data-gallery-alt') || '';
        caption.textContent = trigger.getAttribute('data-gallery-caption') || '';
    }

    function openLightbox(index) {
        renderImage(index);
        lightbox.hidden = false;
        lightbox.setAttribute('aria-hidden', 'false');
        document.body.classList.add('lightbox-open');
    }

    function closeLightbox() {
        lightbox.hidden = true;
        lightbox.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('lightbox-open');
        image.src = '';
    }

    function stepLightbox(direction) {
        var nextIndex = activeIndex + direction;

        if (nextIndex < 0) {
            nextIndex = galleryItems.length - 1;
        }

        if (nextIndex >= galleryItems.length) {
            nextIndex = 0;
        }

        renderImage(nextIndex);
    }

    galleryItems.forEach(function (trigger, index) {
        trigger.addEventListener('click', function () {
            openLightbox(index);
        });
    });

    if (closeButton) {
        closeButton.addEventListener('click', closeLightbox);
    }

    if (prevButton) {
        prevButton.addEventListener('click', function () {
            stepLightbox(-1);
        });
    }

    if (nextButton) {
        nextButton.addEventListener('click', function () {
            stepLightbox(1);
        });
    }

    lightbox.addEventListener('click', function (event) {
        if (event.target === lightbox) {
            closeLightbox();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (lightbox.hidden) {
            return;
        }

        if (event.key === 'Escape') {
            closeLightbox();
        }

        if (event.key === 'ArrowLeft') {
            stepLightbox(-1);
        }

        if (event.key === 'ArrowRight') {
            stepLightbox(1);
        }
    });
})();
