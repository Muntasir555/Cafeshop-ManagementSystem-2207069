/* ============================================================
   BrewHaven Cafe — Home Page JavaScript
   ============================================================ */

/* ---- Navbar scroll effect ---- */
(function () {
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 20) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
})();

/* ---- Mobile menu toggle ---- */
function toggleMobileMenu() {
    const menu = document.getElementById('mobileMenu');
    menu.classList.toggle('open');
}

/* ---- Cart State ---- */
let cartCount = 0;
const stickyBar = document.getElementById('stickyBar');
const cartCountEl = document.getElementById('cartCount');

function addToCart(productId) {
    cartCount++;
    cartCountEl.textContent = cartCount;

    // Show sticky bar
    stickyBar.classList.add('visible');

    // Show toast
    showToast('Added to your order!');
}

function showToast(message) {
    const toast = document.getElementById('cartToast');
    const msg = document.getElementById('cartToastMsg');
    msg.textContent = message;
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 2800);
}

/* ---- Intersection Observer for section animations ---- */
const observerOptions = {
    threshold: 0.15,
    rootMargin: '0px 0px -60px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('in-view');
        }
    });
}, observerOptions);

// Observe product cards
document.querySelectorAll('.product-card').forEach((card, i) => {
    card.style.transitionDelay = `${i * 0.1}s`;
    card.style.opacity = '0';
    card.style.transform = 'translateY(30px)';
    observer.observe(card);
});

// Observe category cards
document.querySelectorAll('.cat-card').forEach((card, i) => {
    card.style.transitionDelay = `${i * 0.07}s`;
    card.style.opacity = '0';
    card.style.transform = 'translateY(20px)';
    observer.observe(card);
});

// Observe reward steps
document.querySelectorAll('.reward-step').forEach((step, i) => {
    step.style.transitionDelay = `${i * 0.2}s`;
    step.style.opacity = '0';
    step.style.transform = 'translateY(30px)';
    observer.observe(step);
});

/* ---- Apply in-view styles ---- */
const styleTag = document.createElement('style');
styleTag.textContent = `
    .product-card.in-view,
    .cat-card.in-view,
    .reward-step.in-view {
        opacity: 1 !important;
        transform: translateY(0) !important;
        transition: opacity 0.55s ease, transform 0.55s ease !important;
    }
`;
document.head.appendChild(styleTag);

/* ---- Smooth anchor scroll for any # links ---- */
document.querySelectorAll('a[href^="#"]').forEach(link => {
    link.addEventListener('click', function (e) {
        const targetId = this.getAttribute('href').slice(1);
        if (!targetId) return;
        const target = document.getElementById(targetId);
        if (target) {
            e.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});

/* ---- Close mobile menu when clicking outside ---- */
document.addEventListener('click', function (e) {
    const menu = document.getElementById('mobileMenu');
    const hamburger = document.getElementById('hamburger');
    if (menu.classList.contains('open') &&
        !menu.contains(e.target) &&
        !hamburger.contains(e.target)) {
        menu.classList.remove('open');
    }
});
