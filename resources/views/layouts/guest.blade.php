@props([
    'pageTitle'     => 'Welcome',
    'leftHeadline'  => 'Good Coffee,<br>Great Moments',
    'leftSubtext'   => 'Join our community of coffee lovers. Earn rewards, explore our menu, and order your favourite drink.',
])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'BrewHaven') }} — {{ $pageTitle }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

    <!-- Auth Styles -->
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>

<div class="auth-wrapper">

    <!-- ═══ LEFT PANEL — Brand Side ═══ -->
    <div class="auth-panel-left">
        <div class="decor-ring"></div>

        <!-- Logo -->
        <div class="auth-logo-wrap">
            <div class="auth-rewards-badge">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="#cba258"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                <span>BrewHaven Rewards</span>
            </div>

            <div class="auth-logo-circle">
                <svg class="auth-logo-svg" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="50" cy="50" r="48" fill="#00754a"/>
                    <text x="50" y="38" text-anchor="middle" fill="white" font-family="Playfair Display,serif" font-size="11" font-weight="700" letter-spacing="2">BREW</text>
                    <text x="50" y="60" text-anchor="middle" fill="white" font-family="serif" font-size="26" font-weight="700">☕</text>
                    <text x="50" y="76" text-anchor="middle" fill="white" font-family="Playfair Display,serif" font-size="9" letter-spacing="3">HAVEN</text>
                </svg>
            </div>

            <div>
                <div class="auth-brand-name">BrewHaven</div>
                <div class="auth-brand-tagline">Coffee & More</div>
            </div>
        </div>

        <!-- Headline -->
        <div class="auth-left-headline">
            <h2>{!! $leftHeadline !!}</h2>
            <p>{!! $leftSubtext !!}</p>
        </div>

        <!-- Perks -->
        <div class="auth-perks">
            <div class="auth-perk-item">
                <div class="auth-perk-icon">⭐</div>
                <div class="auth-perk-text">
                    <strong>Earn Stars</strong>
                    Get stars on every order you place
                </div>
            </div>
            <div class="auth-perk-item">
                <div class="auth-perk-icon">🎁</div>
                <div class="auth-perk-text">
                    <strong>Free Drinks</strong>
                    Redeem stars for your favourite items
                </div>
            </div>
            <div class="auth-perk-item">
                <div class="auth-perk-icon">📱</div>
                <div class="auth-perk-text">
                    <strong>Order Ahead</strong>
                    Skip the queue with easy online ordering
                </div>
            </div>
        </div>
    </div>

    <!-- ═══ RIGHT PANEL — Form Side ═══ -->
    <div class="auth-panel-right">
        <!-- Back to home -->
        <a href="{{ url('/') }}" class="auth-back-home">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
            Back to home
        </a>

        <div class="auth-form-container">
            {{ $slot }}
        </div>
    </div>

</div>

</body>
</html>
