<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Awaiting Approval — BrewHaven</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <style>
        .pending-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1E3932 0%, #006241 50%, #00754a 100%);
            padding: 2rem;
        }
        .pending-card {
            background: #fff;
            border-radius: 20px;
            padding: 3rem 2.5rem;
            max-width: 480px;
            width: 100%;
            text-align: center;
            box-shadow: 0 24px 64px rgba(0,0,0,0.18);
            animation: slideUp 0.5s ease;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .pending-icon-wrap {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: linear-gradient(135deg, #fff8e1 0%, #fffde7 100%);
            border: 3px solid #fbbc05;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2.8rem;
            animation: pulse 2.5s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(251,188,5,0.3); }
            50%       { transform: scale(1.05); box-shadow: 0 0 0 12px rgba(251,188,5,0); }
        }
        .pending-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            margin-bottom: 2rem;
            text-decoration: none;
        }
        .pending-logo span {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            font-weight: 700;
            color: #1E3932;
        }
        .pending-card h1 {
            font-family: 'Playfair Display', serif;
            font-size: 1.75rem;
            color: #1E3932;
            margin-bottom: 0.75rem;
        }
        .pending-card p {
            color: #5c6b66;
            font-size: 0.95rem;
            line-height: 1.7;
            margin-bottom: 1.25rem;
        }
        .pending-status-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: #fff8e1;
            border: 1.5px solid #fbbc05;
            color: #b45309;
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            border-radius: 999px;
            padding: 0.4rem 1.1rem;
            margin-bottom: 1.75rem;
        }
        .pending-status-pill::before {
            content: '';
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #fbbc05;
            animation: blink 1.5s ease-in-out infinite;
        }
        @keyframes blink {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0.2; }
        }
        .pending-steps {
            background: #f8faf9;
            border-radius: 12px;
            padding: 1.25rem 1.5rem;
            text-align: left;
            margin-bottom: 2rem;
        }
        .pending-steps-title {
            font-size: 0.78rem;
            font-weight: 700;
            color: #006241;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            margin-bottom: 0.75rem;
        }
        .pending-step {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin-bottom: 0.6rem;
            font-size: 0.88rem;
            color: #3d5a52;
        }
        .pending-step:last-child { margin-bottom: 0; }
        .step-num {
            flex-shrink: 0;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: #006241;
            color: #fff;
            font-size: 0.7rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 1px;
        }
        .step-done .step-num { background: #cba258; }
        .pending-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        .btn-pending-home {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, #006241 0%, #00754a 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-size: 0.9rem;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            transition: opacity 0.2s;
        }
        .btn-pending-home:hover { opacity: 0.88; }
        .btn-pending-login {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: transparent;
            color: #006241;
            border: 2px solid #006241;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-size: 0.9rem;
            font-weight: 700;
            text-decoration: none;
            transition: background 0.2s, color 0.2s;
        }
        .btn-pending-login:hover {
            background: #006241;
            color: #fff;
        }
    </style>
</head>
<body>
<div class="pending-page">
    <div class="pending-card">

        {{-- Logo --}}
        <a href="{{ url('/') }}" class="pending-logo">
            <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" width="40" height="40">
                <circle cx="50" cy="50" r="48" fill="#006241"/>
                <text x="50" y="38" text-anchor="middle" fill="white" font-family="Playfair Display,serif" font-size="11" font-weight="700" letter-spacing="2">BREW</text>
                <text x="50" y="58" text-anchor="middle" fill="white" font-family="Playfair Display,serif" font-size="22" font-weight="700">☕</text>
                <text x="50" y="74" text-anchor="middle" fill="white" font-family="Playfair Display,serif" font-size="9" letter-spacing="3">HAVEN</text>
            </svg>
            <span>BrewHaven</span>
        </a>

        {{-- Status Icon --}}
        <div class="pending-icon-wrap">⏳</div>

        {{-- Status Pill --}}
        <div class="pending-status-pill">Pending Admin Approval</div>

        <h1>You're Almost In!</h1>

        <p>
            Your account has been successfully created. Before you can log in,
            an admin needs to review and approve your registration.
        </p>

        {{-- Steps --}}
        <div class="pending-steps">
            <div class="pending-steps-title">What happens next</div>
            <div class="pending-step step-done">
                <div class="step-num">✓</div>
                <span>Your account has been created</span>
            </div>
            <div class="pending-step">
                <div class="step-num">2</div>
                <span>Admin reviews your registration request</span>
            </div>
            <div class="pending-step">
                <div class="step-num">3</div>
                <span>Once approved, you can log in and start ordering</span>
            </div>
        </div>

        {{-- Actions --}}
        <div class="pending-actions">
            <a href="{{ url('/') }}" class="btn-pending-home">
                ← Back to Home
            </a>
            <a href="{{ route('login') }}" class="btn-pending-login">
                Try Log In
            </a>
        </div>

    </div>
</div>
</body>
</html>
