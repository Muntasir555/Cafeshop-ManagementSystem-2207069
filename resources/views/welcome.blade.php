<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="BrewHaven Cafe — Premium coffee, teas, and more. Order your favorite drink, earn rewards, and find a store near you.">
    <title>BrewHaven Coffee — Good Coffee, Great Moments</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body>

<!-- ========== TOP PROMO BANNER ========== -->
<div class="promo-top-bar" id="promoBar">
    <p>☕ Free delivery on orders over $25 — <a href="#">Order Now</a></p>
    <button class="promo-close" onclick="document.getElementById('promoBar').style.display='none'">✕</button>
</div>

<!-- ========== NAVBAR ========== -->
<header class="navbar" id="navbar">
    <div class="nav-container">

        <!-- Left: Nav Links -->
        <nav class="nav-left">
            <a href="{{ url('/') }}" class="nav-link">Home</a>
            <a href="{{ route('menu') }}" class="nav-link">Menu</a>
            <a href="{{ route('rewards') }}" class="nav-link">Rewards</a>
            <a href="#" class="nav-link">Gift Cards</a>
        </nav>

        <!-- Center: Logo -->
        <a href="/" class="nav-logo" aria-label="BrewHaven Dashboard">
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
        <a href="#">Gift Cards</a>
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

<!-- ========== MAIN CONTENT ========== -->
<main>

    <!-- ===== HERO BANNERS SECTION ===== -->
    <section class="hero-banners" aria-label="Promotions">

        <!-- Hero 1: Main Cold Brew -->
        <div class="hero-slide" style="background-color:#1e3932;">
            <div class="hero-img-wrap hero-img-left">
                <img src="{{ asset('images/banners/banner_hero_main.png') }}" alt="Iced Cold Brew Coffee" class="hero-img" loading="eager">
            </div>
            <div class="hero-text hero-text-right">
                <span class="hero-eyebrow">NEW ARRIVAL</span>
                <h2 class="hero-title" style="color:#fff;">Cold Brew<br>Season is Here</h2>
                <p class="hero-sub" style="color:#d4e9e2;">Smooth, rich, and made to order.<br>Find your perfect cold brew today.</p>
                <div class="hero-actions">
                    <a href="#" class="btn-hero-white">Order now</a>
                    <a href="#" class="btn-hero-outline-white">Learn more</a>
                </div>
            </div>
        </div>

        <!-- Hero 2: S'mores Collection -->
        <div class="hero-slide" style="background-color:#2c1a0e;">
            <div class="hero-text hero-text-left">
                <span class="hero-eyebrow" style="color:#cba258;">LIMITED TIME</span>
                <h2 class="hero-title" style="color:#fff;">S'mores Season<br>Has Arrived</h2>
                <p class="hero-sub" style="color:#e8d5c4;">Toasty marshmallow, rich chocolate,<br>and graham — in every sip.</p>
                <div class="hero-actions">
                    <a href="#" class="btn-hero-gold">Try it now</a>
                    <a href="#" class="btn-hero-outline-gold">See the collection</a>
                </div>
            </div>
            <div class="hero-img-wrap hero-img-right">
                <img src="{{ asset('images/banners/banner_smores.png') }}" alt="S'mores Coffee Collection" class="hero-img" loading="lazy">
            </div>
        </div>

        <!-- Hero 3: Pink Merchandise -->
        <div class="hero-slide" style="background-color:#fce4ec;">
            <div class="hero-img-wrap hero-img-left">
                <img src="{{ asset('images/banners/banner_pink_cups.png') }}" alt="Limited Edition Pink Tumblers" class="hero-img" loading="lazy">
            </div>
            <div class="hero-text hero-text-right">
                <span class="hero-eyebrow" style="color:#c2185b;">LIMITED EDITION</span>
                <h2 class="hero-title" style="color:#880e4f;">Pretty in Pink<br>Collection</h2>
                <p class="hero-sub" style="color:#ad1457;">Our limited-edition tumblers are here.<br>Grab yours before they're gone.</p>
                <div class="hero-actions">
                    <a href="#" class="btn-hero-pink">Shop now</a>
                    <a href="#" class="btn-hero-outline-pink">View all</a>
                </div>
            </div>
        </div>

        <!-- Hero 4: Summer Refreshers -->
        <div class="hero-slide" style="background-color:#004b49;">
            <div class="hero-text hero-text-left">
                <span class="hero-eyebrow" style="color:#80cbc4;">SUMMER SERIES</span>
                <h2 class="hero-title" style="color:#fff;">Chill Out with<br>Summer Refreshers</h2>
                <p class="hero-sub" style="color:#b2dfdb;">Vibrant tropical flavors.<br>The perfect cool-down drink.</p>
                <div class="hero-actions">
                    <a href="#" class="btn-hero-teal">Explore flavors</a>
                    <a href="#" class="btn-hero-outline-teal">Order now</a>
                </div>
            </div>
            <div class="hero-img-wrap hero-img-right">
                <img src="{{ asset('images/banners/banner_summer.png') }}" alt="Summer Tropical Refreshers" class="hero-img" loading="lazy">
            </div>
        </div>

        <!-- Hero 5: Protein Drinks -->
        <div class="hero-slide" style="background-color:#fffde7;">
            <div class="hero-img-wrap hero-img-left">
                <img src="{{ asset('images/banners/banner_protein.png') }}" alt="Protein Coffee Drinks" class="hero-img" loading="lazy">
            </div>
            <div class="hero-text hero-text-right">
                <span class="hero-eyebrow" style="color:#f9a825;">WELLNESS</span>
                <h2 class="hero-title" style="color:#333;">Power Up Your<br>Morning Routine</h2>
                <p class="hero-sub" style="color:#555;">High-protein drinks that taste incredible.<br>Fuel for whatever comes next.</p>
                <div class="hero-actions">
                    <a href="#" class="btn-hero-yellow">Discover now</a>
                    <a href="#" class="btn-hero-outline-yellow">See all options</a>
                </div>
            </div>
        </div>

        <!-- Hero 6: Rewards -->
        <div class="hero-slide" style="background-color:#1e3932;">
            <div class="hero-text hero-text-left">
                <span class="hero-eyebrow" style="color:#cba258;">⭐ REWARDS</span>
                <h2 class="hero-title" style="color:#fff;">Earn Stars,<br>Get Free Drinks</h2>
                <p class="hero-sub" style="color:#d4e9e2;">Join BrewHaven Rewards and earn stars<br>with every purchase. The more you drink,<br>the more you save.</p>
                <div class="hero-actions">
                    <a href="{{ route('register') }}" class="btn-hero-gold">Join for free</a>
                    <a href="#" class="btn-hero-outline-white">Learn more</a>
                </div>
            </div>
            <div class="hero-img-wrap hero-img-right">
                <img src="{{ asset('images/banners/banner_rewards.png') }}" alt="BrewHaven Rewards Program" class="hero-img" loading="lazy">
            </div>
        </div>

    </section>

    <!-- ===== FEATURED PRODUCTS ===== -->
    <section class="featured-section" id="featured">
        <div class="section-container">
            <div class="section-header">
                <span class="section-eyebrow">Our Favourites</span>
                <h2 class="section-title">Customer Favourites</h2>
                <p class="section-sub">Discover the drinks everyone's talking about</p>
            </div>

            <div class="products-grid">

                <article class="product-card" id="product-caramel-macchiato">
                    <a href="#" class="product-card-link">
                        <div class="product-img-wrap">
                            <img src="{{ asset('images/products/caramel_macchiato.png') }}" alt="Iced Caramel Macchiato" class="product-img" loading="lazy">
                            <div class="product-badge">Fan Fave</div>
                        </div>
                        <div class="product-info">
                            <h3 class="product-name">Iced Caramel Macchiato</h3>
                            <p class="product-cal">250 calories</p>
                            <p class="product-desc">Freshly steamed milk with vanilla-flavoured syrup, espresso, and caramel drizzle.</p>
                            <span class="product-price">From $5.75</span>
                        </div>
                    </a>
                    <button class="product-add-btn" onclick="addToCart('caramel-macchiato')">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                        Add to order
                    </button>
                </article>

                <article class="product-card" id="product-frappuccino">
                    <a href="#" class="product-card-link">
                        <div class="product-img-wrap">
                            <img src="{{ asset('images/products/frappuccino.png') }}" alt="Caramel Frappuccino" class="product-img" loading="lazy">
                            <div class="product-badge product-badge-new">New</div>
                        </div>
                        <div class="product-info">
                            <h3 class="product-name">Caramel Frappuccino</h3>
                            <p class="product-cal">380 calories</p>
                            <p class="product-desc">Coffee blended with milk and ice, topped with whipped cream and buttery caramel sauce.</p>
                            <span class="product-price">From $6.25</span>
                        </div>
                    </a>
                    <button class="product-add-btn" onclick="addToCart('frappuccino')">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                        Add to order
                    </button>
                </article>

                <article class="product-card" id="product-matcha-latte">
                    <a href="#" class="product-card-link">
                        <div class="product-img-wrap">
                            <img src="{{ asset('images/products/matcha_latte.png') }}" alt="Iced Matcha Latte" class="product-img" loading="lazy">
                        </div>
                        <div class="product-info">
                            <h3 class="product-name">Iced Matcha Latte</h3>
                            <p class="product-cal">200 calories</p>
                            <p class="product-desc">Smooth premium matcha blended with creamy oat milk over a bed of ice.</p>
                            <span class="product-price">From $5.45</span>
                        </div>
                    </a>
                    <button class="product-add-btn" onclick="addToCart('matcha-latte')">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                        Add to order
                    </button>
                </article>

                <article class="product-card" id="product-cold-brew">
                    <a href="#" class="product-card-link">
                        <div class="product-img-wrap">
                            <img src="{{ asset('images/products/cold_brew.png') }}" alt="Sweet Cream Cold Brew" class="product-img" loading="lazy">
                            <div class="product-badge product-badge-hot">Trending</div>
                        </div>
                        <div class="product-info">
                            <h3 class="product-name">Sweet Cream Cold Brew</h3>
                            <p class="product-cal">185 calories</p>
                            <p class="product-desc">Slow-steeped cold brew topped with a float of house-made vanilla sweet cream.</p>
                            <span class="product-price">From $5.95</span>
                        </div>
                    </a>
                    <button class="product-add-btn" onclick="addToCart('cold-brew')">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                        Add to order
                    </button>
                </article>

            </div>

            <div class="section-cta">
                <a href="{{ route('menu') }}" class="btn-outline-green">View full menu</a>
            </div>
        </div>
    </section>

    <!-- ===== REWARDS PROMO STRIP ===== -->
    <section class="rewards-strip" id="rewards-strip">
        <div class="rewards-strip-inner">
            <div class="rewards-strip-content">
                <div class="rewards-stars-anim">
                    <span class="star-icon">⭐</span>
                    <span class="star-icon star-2">⭐</span>
                    <span class="star-icon star-3">⭐</span>
                </div>
                <div class="rewards-strip-text">
                    <h2>Join BrewHaven Rewards</h2>
                    <p>Earn stars with every order. Redeem them for free drinks, food, and more. It's free to join.</p>
                </div>
                <div class="rewards-strip-actions">
                    <a href="{{ route('register') }}" class="btn-white-green">Join for free</a>
                    <a href="#" class="btn-outline-white">Learn more</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== HOW REWARDS WORKS ===== -->
    <section class="how-rewards" id="how-rewards">
        <div class="section-container">
            <div class="section-header">
                <span class="section-eyebrow">Rewards Program</span>
                <h2 class="section-title">How it Works</h2>
            </div>
            <div class="rewards-steps">
                <div class="reward-step" id="step-1">
                    <div class="step-icon-wrap">
                        <div class="step-icon">👤</div>
                        <div class="step-num">01</div>
                    </div>
                    <h3>Create Account</h3>
                    <p>Sign up for free in minutes. No credit card required to join.</p>
                </div>
                <div class="step-connector"></div>
                <div class="reward-step" id="step-2">
                    <div class="step-icon-wrap">
                        <div class="step-icon">☕</div>
                        <div class="step-num">02</div>
                    </div>
                    <h3>Order & Pay</h3>
                    <p>Order in-store, online, or through our app. Every purchase earns stars.</p>
                </div>
                <div class="step-connector"></div>
                <div class="reward-step" id="step-3">
                    <div class="step-icon-wrap">
                        <div class="step-icon">⭐</div>
                        <div class="step-num">03</div>
                    </div>
                    <h3>Redeem Stars</h3>
                    <p>Use your stars for free drinks, customisations, and exclusive offers.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== MENU CATEGORIES GRID ===== -->
    <section class="categories-section" id="menu-categories">
        <div class="section-container">
            <div class="section-header">
                <span class="section-eyebrow">Explore Our Menu</span>
                <h2 class="section-title">What Are You Craving?</h2>
            </div>
            <div class="categories-grid">
                <a href="{{ route('menu') }}?category=Cold+Drinks" class="cat-card" id="cat-cold-drinks">
                    <div class="cat-icon">🧊</div>
                    <h3>Cold Drinks</h3>
                    <span class="cat-count">24 items</span>
                </a>
                <a href="{{ route('menu') }}?category=Hot+Drinks" class="cat-card" id="cat-hot-drinks">
                    <div class="cat-icon">☕</div>
                    <h3>Hot Drinks</h3>
                    <span class="cat-count">18 items</span>
                </a>
                <a href="{{ route('menu') }}?category=Frappuccino" class="cat-card" id="cat-frappuccino">
                    <div class="cat-icon">🥤</div>
                    <h3>Frappuccino</h3>
                    <span class="cat-count">12 items</span>
                </a>
                <a href="{{ route('menu') }}?category=Teas+%26+Chai" class="cat-card" id="cat-teas">
                    <div class="cat-icon">🍵</div>
                    <h3>Teas & Chai</h3>
                    <span class="cat-count">16 items</span>
                </a>
                <a href="{{ route('menu') }}?category=Bakery" class="cat-card" id="cat-bakery">
                    <div class="cat-icon">🥐</div>
                    <h3>Bakery</h3>
                    <span class="cat-count">14 items</span>
                </a>
                <a href="{{ route('menu') }}?category=Food+%26+Snacks" class="cat-card" id="cat-food">
                    <div class="cat-icon">🥗</div>
                    <h3>Food & Snacks</h3>
                    <span class="cat-count">20 items</span>
                </a>
                <a href="{{ route('menu') }}?category=Merchandise" class="cat-card" id="cat-merch">
                    <div class="cat-icon">🛍️</div>
                    <h3>Merchandise</h3>
                    <span class="cat-count">30 items</span>
                </a>
                <a href="{{ route('menu') }}?category=Gift+Cards" class="cat-card" id="cat-gift-cards">
                    <div class="cat-icon">🎁</div>
                    <h3>Gift Cards</h3>
                    <span class="cat-count">8 designs</span>
                </a>
            </div>
        </div>
    </section>

    <!-- ===== APP DOWNLOAD SECTION ===== -->
    <section class="app-section" id="app-section">
        <div class="app-section-inner">
            <div class="app-content">
                <div class="app-text">
                    <span class="section-eyebrow" style="color:#80cbc4;">Mobile App</span>
                    <h2>Order Ahead,<br>Skip the Queue</h2>
                    <p>Download the BrewHaven app. Order your favourite drink before you even leave the house. Pay, earn stars, and track your rewards all in one place.</p>
                    <div class="app-badges">
                        <a href="#" class="app-badge" id="app-store-btn">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/></svg>
                            <div>
                                <span class="badge-small">Download on the</span>
                                <span class="badge-big">App Store</span>
                            </div>
                        </a>
                        <a href="#" class="app-badge" id="play-store-btn">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M3.18 23.76c.3.17.64.24.99.2l12.43-7.17-2.68-2.68-10.74 9.65zM.5 1.44C.19 1.76 0 2.27 0 2.94v18.12c0 .67.19 1.18.51 1.5l.08.07 10.15-10.15v-.24L.58 1.37.5 1.44zM20.37 10.55l-2.9-1.67-3.01 3.01 3.01 3.01 2.92-1.68c.83-.48.83-1.26-.02-1.67zM4.17.24l12.43 7.17-2.68 2.68L3.18.44a1.1 1.1 0 01.99-.2z"/></svg>
                            <div>
                                <span class="badge-small">Get it on</span>
                                <span class="badge-big">Google Play</span>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="app-mockup">
                    <div class="phone-frame">
                        <div class="phone-screen">
                            <div class="phone-screen-content">
                                <div class="phone-header">
                                    <div class="phone-avatar">🧑</div>
                                    <div>
                                        <div class="phone-greeting">Good morning!</div>
                                        <div class="phone-name">Alex</div>
                                    </div>
                                </div>
                                <div class="phone-stars">
                                    <div class="phone-stars-label">⭐ Your Stars</div>
                                    <div class="phone-stars-count">342</div>
                                    <div class="phone-stars-bar"><div class="phone-stars-fill" style="width:68%"></div></div>
                                    <div class="phone-stars-next">32 more for a free drink</div>
                                </div>
                                <div class="phone-order-btn">Start New Order →</div>
                                <div class="phone-recent">
                                    <div class="phone-recent-label">Order Again?</div>
                                    <div class="phone-recent-item">
                                        <span>☕</span>
                                        <span>Iced Caramel Macchiato</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="phone-notch"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== STORE LOCATOR CTA ===== -->
    <section class="store-section" id="store-section">
        <div class="section-container">
            <div class="store-cta-card">
                <div class="store-map-icon">
                    <svg viewBox="0 0 24 24" fill="#006241" width="48" height="48">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                    </svg>
                </div>
                <div class="store-text">
                    <h2>Find a Store Near You</h2>
                    <p>Locate your nearest BrewHaven cafe. Check hours, services, and order for pickup or drive-thru.</p>
                    <a href="#" class="btn-outline-green" id="find-store-btn">Find a store</a>
                </div>
                <div class="store-info-cards">
                    <div class="store-info-card">
                        <span class="store-info-icon">🕐</span>
                        <span>Open 7 days<br>from 6am</span>
                    </div>
                    <div class="store-info-card">
                        <span class="store-info-icon">🚗</span>
                        <span>Drive-thru<br>available</span>
                    </div>
                    <div class="store-info-card">
                        <span class="store-info-icon">📱</span>
                        <span>Mobile<br>ordering</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

<!-- ========== FOOTER ========== -->
<footer class="footer" id="footer">
    <div class="footer-top">
        <div class="footer-container">

            <div class="footer-col">
                <h4>About Us</h4>
                <ul>
                    <li><a href="#">Our Story</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">Community</a></li>
                    <li><a href="#">Sustainability</a></li>
                    <li><a href="#">Press</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Customer Service</h4>
                <ul>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">FAQs</a></li>
                    <li><a href="#">Order Help</a></li>
                    <li><a href="#">Accessibility</a></li>
                    <li><a href="#">Gift Cards</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Rewards</h4>
                <ul>
                    <li><a href="{{ route('rewards') }}">Join Rewards</a></li>
                    <li><a href="#">How it Works</a></li>
                    <li><a href="#">Redeem Stars</a></li>
                    <li><a href="#">Tier Benefits</a></li>
                    <li><a href="#">Partner Rewards</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Legal</h4>
                <ul>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Use</a></li>
                    <li><a href="#">Cookie Settings</a></li>
                    <li><a href="#">Do Not Sell</a></li>
                    <li><a href="#">CA Supply Chain</a></li>
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
                <div class="footer-social">
                    <a href="#" class="social-link" aria-label="Instagram">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="22" height="22"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </a>
                    <a href="#" class="social-link" aria-label="Facebook">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="22" height="22"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="#" class="social-link" aria-label="Twitter/X">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="22" height="22"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                    <a href="#" class="social-link" aria-label="YouTube">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="22" height="22"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </a>
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
                <a href="#">Cookies</a>
            </div>
        </div>
    </div>
</footer>

<!-- Cart Toast Notification -->
<div class="cart-toast" id="cartToast">
    <span class="toast-icon">✓</span>
    <span id="cartToastMsg">Added to your order!</span>
</div>

<!-- Sticky Order Bar -->
<div class="sticky-order-bar" id="stickyBar">
    <div class="sticky-bar-inner">
        <span>🛒 <strong id="cartCount">0</strong> items in your order</span>
        <a href="#" class="btn-sticky-order">View Order</a>
    </div>
</div>

<script src="{{ asset('js/home.js') }}"></script>
</body>
</html>
