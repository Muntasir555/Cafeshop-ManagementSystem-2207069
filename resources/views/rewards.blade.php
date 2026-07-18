<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="BrewHaven Rewards — Free coffee is just the beginning. Join now to start enjoying exclusive benefits.">
    <title>BrewHaven Rewards</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&family=Playfair+Display:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/rewards.css') }}">
</head>
<body>

<!-- ========== NAVBAR ========== -->
<header class="navbar" id="navbar">
    <div class="nav-container">
        <!-- Left: Nav Links -->
        <nav class="nav-left">
            <a href="{{ url('/') }}" class="nav-link">Home</a>
            <a href="{{ route('menu') }}" class="nav-link">Menu</a>
            <a href="{{ route('rewards') }}" class="nav-link" style="color: var(--green-primary);">Rewards</a>
            <a href="{{ route('gift.cards') }}" class="nav-link">Gift Cards</a>
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

<!-- ========== REWARDS STICKY HEADER ========== -->
<div class="rewards-header">
    <span>BrewHaven Rewards</span>
    @guest
    <a href="{{ route('register') }}" class="rewards-header-btn">Join in the app</a>
    @endguest
</div>

<!-- ========== MAIN CONTENT ========== -->
<main>

    <!-- ===== REWARDS HERO ===== -->
    <section class="rewards-hero">
        <div class="rewards-hero-content">
            <h1>Free coffee<br>is a tap away</h1>
            <p>Join now to start earning Stars, enjoying exclusive benefits, and unlocking more of what you love.</p>
            <div>
                @auth
                    <a href="{{ route('dashboard') }}" class="nav-btn-join">Go to Dashboard</a>
                @else
                    <a href="{{ route('register') }}" class="nav-btn-join">Join now</a>
                    <a href="{{ route('login') }}" class="nav-link" style="display:inline-block; margin-left: 12px; font-size: 1rem;">Or sign in</a>
                @endauth
            </div>
        </div>
        <div class="rewards-hero-image-wrap">
            <img src="{{ asset('images/rewards/hero.png') }}" alt="Cinematic iced coffee with gold stars" class="rewards-hero-image">
        </div>
    </section>

    <!-- ===== HOW IT WORKS ===== -->
    <section class="rewards-steps-section">
        <h2>Getting started is easy</h2>
        <p class="section-sub">Earn Stars and get rewarded in a few simple steps.</p>
        
        <div class="steps-grid">
            <div class="step-card">
                <div class="step-icon-num">1</div>
                <h3>Create an account</h3>
                <p>To get started, <a href="{{ route('register') }}" style="color:var(--green-primary); text-decoration:underline;">join now</a>. You can also join in the app to get access to the full range of BrewHaven Rewards benefits.</p>
            </div>
            <div class="step-card">
                <div class="step-icon-num">2</div>
                <h3>Order and pay how you'd like</h3>
                <p>Use cash, credit/debit card, or save some time and pay right through the app. You'll collect Stars all ways.</p>
            </div>
            <div class="step-card">
                <div class="step-icon-num">3</div>
                <h3>Earn Stars, get Rewards</h3>
                <p>As you earn Stars, you can redeem them for Rewards—like free food, drinks, and more. Start redeeming with as little as 25 Stars!</p>
            </div>
        </div>
    </section>

    <!-- ===== TIERS SECTION ===== -->
    <section class="rewards-tiers-section">
        <h2>Get rewarded for your routine</h2>
        <div class="tiers-grid">
            
            <div class="tier-card green-tier">
                <div class="tier-stars">Green Status</div>
                <div class="tier-name">0 - 499 Stars</div>
                <p>Start earning immediately when you join. Perfect for the occasional treat.</p>
                <ul>
                    <li>Earn 1★ per $1 spent</li>
                    <li>Free 1-day Birthday Treat</li>
                    <li>Order ahead on the app</li>
                </ul>
            </div>

            <div class="tier-card gold-tier">
                <div class="tier-stars">Gold Status</div>
                <div class="tier-name">500+ Stars</div>
                <p>For our regular guests. Unlock faster earning and more flexibility.</p>
                <ul>
                    <li>Earn 1.2★ per $1 spent</li>
                    <li>Free 7-day Birthday Treat</li>
                    <li>Free syrup customizations</li>
                    <li>Exclusive double-star days</li>
                </ul>
            </div>

            <div class="tier-card reserve-tier">
                <div class="tier-stars">Reserve Status</div>
                <div class="tier-name">2,500+ Stars</div>
                <p>The ultimate BrewHaven experience with maximum perks.</p>
                <ul>
                    <li>Earn 1.7★ per $1 spent</li>
                    <li>Free 30-day Birthday Treat</li>
                    <li>Free bakery item every month</li>
                    <li>Early access to new menus</li>
                </ul>
            </div>

        </div>
    </section>

    <!-- ===== APP PROMO ===== -->
    <section class="app-promo-section">
        <div class="app-promo-image-wrap">
            <img src="{{ asset('images/rewards/app.png') }}" alt="BrewHaven rewards app on mobile" class="app-promo-image">
        </div>
        <div class="app-promo-content">
            <h2>Endless Extras<br>in the App</h2>
            <p>Track your Stars, play exclusive games, and order ahead with ease. The BrewHaven app is the key to getting the most out of your Rewards.</p>
            <div>
                <a href="#" class="btn-outline-white" style="border: 2px solid white; padding: 12px 24px; border-radius: 99px; display: inline-block; font-weight: bold;">Download the App</a>
            </div>
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
