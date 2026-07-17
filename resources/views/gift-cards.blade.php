<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="BrewHaven Gift Cards — The perfect gift for any coffee lover. Send an eGift or check your balance.">
    <title>BrewHaven Gift Cards</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&family=Playfair+Display:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/gift-cards.css') }}">
</head>
<body>

<!-- ========== NAVBAR ========== -->
<header class="navbar" id="navbar">
    <div class="nav-container">
        <!-- Left: Nav Links -->
        <nav class="nav-left">
            <a href="{{ url('/') }}" class="nav-link">Home</a>
            <a href="{{ route('menu') }}" class="nav-link">Menu</a>
            <a href="{{ route('rewards') }}" class="nav-link">Rewards</a>
            <a href="{{ route('gift.cards') }}" class="nav-link" style="color: var(--green-primary);">Gift Cards</a>
        </nav>

        <!-- Center: Logo -->
        <a href="/" class="nav-logo" aria-label="BrewHaven Home">
            <div class="logo-circle">
                <div class="logo-icon">
                    <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="50" cy="50" r="48" fill="#006241"/>
                        <text x="50" y="38" text-anchor="middle" fill="white" font-family="Playfair Display,serif" font-size="11" font-weight="700" letter-spacing="2">BREW</text>
                        <text x="50" y="58" text-anchor="middle" fill="white" font-family="Playfair Display,serif" font-size="22" font-weight="700">☕</text>
                        <text x="50" y="74" text-anchor="middle" fill="white" font-family="Playfair Display,serif" font-size="9" letter-spacing="3">HAVEN</text>
                    </svg>
                </div>
            </div>
        </a>

        <!-- Right: Actions -->
        <nav class="nav-right">
            <a href="#" class="nav-link nav-store-link">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                Find a Store
            </a>
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">Admin</a>
                @else
                    <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" class="nav-btn-join">Log out</a>
                </form>
            @else
                <a href="{{ route('login') }}" class="nav-link">Sign in</a>
                <a href="{{ route('register') }}" class="nav-btn-join">Join now</a>
            @endauth
        </nav>

        <!-- Mobile Hamburger -->
        <button class="nav-hamburger" id="hamburger" onclick="toggleMobileMenu()" aria-label="Open menu">
            <span></span><span></span><span></span>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <a href="{{ url('/') }}">Home</a>
        <a href="{{ route('menu') }}">Menu</a>
        <a href="{{ route('rewards') }}">Rewards</a>
        <a href="{{ route('gift.cards') }}">Gift Cards</a>
        <a href="#">Find a Store</a>
        @auth
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}">Admin</a>
            @else
                <a href="{{ route('dashboard') }}">Dashboard</a>
            @endif
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" class="mobile-join">Log out</a>
            </form>
        @else
            <a href="{{ route('login') }}">Sign in</a>
            <a href="{{ route('register') }}" class="mobile-join">Join now</a>
        @endauth
    </div>
</header>

<!-- ========== GIFT CARDS HEADER ========== -->
<div class="gc-header">
    <h1>Gift Cards</h1>
</div>

<!-- ========== MAIN CONTENT ========== -->
<main>

    <!-- ===== HERO SECTION ===== -->
    <section class="gc-hero">
        <div class="gc-hero-text">
            <h2>Gift the perfect cup</h2>
            <p>A BrewHaven Gift Card is the perfect way to say thanks, happy birthday, or just because. Send an eGift or pick up a physical card in-store.</p>
            <div>
                <a href="#featured" class="gc-btn" style="background:var(--white); color:var(--green-darkest);">Shop eGifts</a>
            </div>
        </div>
        <div class="gc-hero-image-wrap">
            <img src="{{ asset('images/gift-cards/hero.png') }}" alt="Beautifully wrapped gift box next to a coffee cup" class="gc-hero-image">
        </div>
    </section>

    <!-- ===== QUICK LINKS ===== -->
    <section class="gc-quick-links">
        <a href="#featured" class="gc-quick-link-card">
            <div class="gc-quick-link-icon">✉️</div>
            <h3>Send an eGift</h3>
        </a>
        <a href="#balance" class="gc-quick-link-card">
            <div class="gc-quick-link-icon">💳</div>
            <h3>Check Balance</h3>
        </a>
        <a href="#" class="gc-quick-link-card">
            <div class="gc-quick-link-icon">🏢</div>
            <h3>Corporate Sales</h3>
        </a>
        <a href="#" class="gc-quick-link-card">
            <div class="gc-quick-link-icon">📱</div>
            <h3>Add to App</h3>
        </a>
    </section>

    <!-- ===== FEATURED CARDS ===== -->
    <section class="gc-category" id="featured">
        <h2>Featured</h2>
        <div class="gc-cards-grid">
            <div class="gc-card-item">
                <img src="{{ asset('images/gift-cards/card_coffee.png') }}" alt="Latte Art Gift Card" class="gc-card-img">
            </div>
            <div class="gc-card-item">
                <img src="{{ asset('images/gift-cards/card_thankyou.png') }}" alt="Thank You Gift Card" class="gc-card-img">
            </div>
            <div class="gc-card-item">
                <img src="{{ asset('images/gift-cards/card_birthday.png') }}" alt="Birthday Gift Card" class="gc-card-img">
            </div>
        </div>
    </section>

    <!-- ===== THANK YOU CARDS ===== -->
    <section class="gc-category">
        <h2>Thank You</h2>
        <div class="gc-cards-grid">
            <div class="gc-card-item">
                <img src="{{ asset('images/gift-cards/card_thankyou.png') }}" alt="Thank You Gift Card" class="gc-card-img">
            </div>
            <div class="gc-card-item">
                <img src="{{ asset('images/gift-cards/card_coffee.png') }}" alt="Latte Art Gift Card" class="gc-card-img">
            </div>
        </div>
    </section>

    <!-- ===== BIRTHDAY CARDS ===== -->
    <section class="gc-category">
        <h2>Birthdays</h2>
        <div class="gc-cards-grid">
            <div class="gc-card-item">
                <img src="{{ asset('images/gift-cards/card_birthday.png') }}" alt="Birthday Gift Card" class="gc-card-img">
            </div>
        </div>
    </section>

    <!-- ===== CHECK BALANCE ===== -->
    <section class="gc-balance-section" id="balance">
        <div class="gc-balance-container">
            <h2>Check Balance</h2>
            <p>Check the balance of your BrewHaven Gift Card.</p>
            <form class="gc-balance-form" onsubmit="event.preventDefault(); alert('Balance check is not implemented yet.');">
                <input type="text" placeholder="Card Number" class="gc-input" required>
                <input type="text" placeholder="Security Code" class="gc-input" required>
                <button type="submit" class="gc-btn">Check Balance</button>
            </form>
        </div>
    </section>

</main>

<!-- ========== FOOTER ========== -->
<footer class="footer" id="footer" style="margin-top: 0;">
    <div class="footer-top">
        <div class="footer-container">
            <div class="footer-col">
                <h4>About Us</h4>
                <ul>
                    <li><a href="#">Our Story</a></li>
                    <li><a href="#">Careers</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Customer Service</h4>
                <ul>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">FAQs</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Rewards</h4>
                <ul>
                    <li><a href="{{ route('rewards') }}">Join Rewards</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                </ul>
            </div>
            <div class="footer-col footer-col-brand">
                <div class="footer-logo">
                    <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" width="80" height="80">
                        <circle cx="50" cy="50" r="48" fill="#006241"/>
                        <text x="50" y="38" text-anchor="middle" fill="white" font-family="serif" font-size="11" font-weight="700" letter-spacing="2">BREW</text>
                        <text x="50" y="58" text-anchor="middle" fill="white" font-family="serif" font-size="22" font-weight="700">☕</text>
                        <text x="50" y="74" text-anchor="middle" fill="white" font-family="serif" font-size="9" letter-spacing="3">HAVEN</text>
                    </svg>
                </div>
                <p class="footer-tagline">"Good coffee, great moments."</p>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="footer-container footer-bottom-inner">
            <p>&copy; 2026 BrewHaven Coffee Company. All rights reserved.</p>
            <div class="footer-bottom-links">
                <a href="#">Privacy</a>
                <a href="#">Terms</a>
            </div>
        </div>
    </div>
</footer>

<script>
    // Simple script for mobile menu toggle to keep it functional
    function toggleMobileMenu() {
        document.getElementById('mobileMenu').classList.toggle('open');
    }
</script>
</body>
</html>
