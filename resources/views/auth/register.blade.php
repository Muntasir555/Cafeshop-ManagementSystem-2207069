<x-guest-layout
    pageTitle="Create Account"
    leftHeadline="Join the<br>BrewHaven family."
    leftSubtext="Create your free account in seconds and start earning rewards on every order you make."
>

    <!-- Form Header -->
    <div class="auth-form-header">
        <h1>Create account</h1>
        <p>It's free and takes less than a minute.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="auth-form" id="registerForm">
        @csrf

        <!-- Full Name -->
        <div class="auth-field">
            <label for="name" class="auth-field-label">Full name</label>
            <input
                id="name"
                name="name"
                type="text"
                value="{{ old('name') }}"
                required
                autofocus
                autocomplete="name"
                placeholder="Your full name"
                class="auth-field-input {{ $errors->get('name') ? 'is-error' : '' }}"
            >
            <svg class="auth-field-icon" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
            </svg>
            @foreach ($errors->get('name') as $error)
                <div class="auth-field-error">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                    {{ $error }}
                </div>
            @endforeach
        </div>

        <!-- Email -->
        <div class="auth-field">
            <label for="email" class="auth-field-label">Email address</label>
            <input
                id="email"
                name="email"
                type="email"
                value="{{ old('email') }}"
                required
                autocomplete="username"
                placeholder="you@example.com"
                class="auth-field-input {{ $errors->get('email') ? 'is-error' : '' }}"
            >
            <svg class="auth-field-icon" viewBox="0 0 24 24" fill="currentColor">
                <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
            </svg>
            @foreach ($errors->get('email') as $error)
                <div class="auth-field-error">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                    {{ $error }}
                </div>
            @endforeach
        </div>

        <!-- Password -->
        <div class="auth-field">
            <label for="password" class="auth-field-label">Password</label>
            <input
                id="password"
                name="password"
                type="password"
                required
                autocomplete="new-password"
                placeholder="Create a password"
                class="auth-field-input {{ $errors->get('password') ? 'is-error' : '' }}"
                oninput="checkPasswordStrength(this.value)"
            >
            <svg class="auth-field-icon clickable" viewBox="0 0 24 24" fill="currentColor" onclick="togglePassword('password', this)" title="Show/hide password">
                <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
            </svg>
            @foreach ($errors->get('password') as $error)
                <div class="auth-field-error">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                    {{ $error }}
                </div>
            @endforeach
            <!-- Password Strength Bar -->
            <div class="pwd-strength-bar" id="pwdStrengthBar" style="display:none; margin-top:8px;">
                <div class="pwd-strength-track">
                    <div class="pwd-strength-fill" id="pwdStrengthFill"></div>
                </div>
                <span class="pwd-strength-label" id="pwdStrengthLabel"></span>
            </div>
        </div>

        <!-- Confirm Password -->
        <div class="auth-field">
            <label for="password_confirmation" class="auth-field-label">Confirm password</label>
            <input
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                required
                autocomplete="new-password"
                placeholder="Repeat your password"
                class="auth-field-input {{ $errors->get('password_confirmation') ? 'is-error' : '' }}"
            >
            <svg class="auth-field-icon clickable" viewBox="0 0 24 24" fill="currentColor" onclick="togglePassword('password_confirmation', this)" title="Show/hide password">
                <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
            </svg>
            @foreach ($errors->get('password_confirmation') as $error)
                <div class="auth-field-error">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                    {{ $error }}
                </div>
            @endforeach
        </div>

        <!-- Terms -->
        <p class="auth-terms">
            By creating an account, you agree to our
            <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.
        </p>

        <!-- Submit -->
        <button type="submit" class="auth-btn-primary" id="registerSubmit">
            Create my account
        </button>

        <!-- Divider -->
        <div class="auth-divider">already have an account?</div>

        <!-- Switch to login -->
        <div class="auth-switch">
            <a href="{{ route('login') }}">Sign in instead</a>
        </div>

    </form>

</x-guest-layout>

<style>
/* Password Strength Indicator */
.pwd-strength-bar {
    display: flex;
    align-items: center;
    gap: 10px;
}
.pwd-strength-track {
    flex: 1;
    height: 4px;
    background: #e5e9e7;
    border-radius: 4px;
    overflow: hidden;
}
.pwd-strength-fill {
    height: 100%;
    border-radius: 4px;
    width: 0%;
    transition: width 0.4s ease, background 0.4s ease;
}
.pwd-strength-label {
    font-size: 11px;
    font-weight: 700;
    white-space: nowrap;
    min-width: 44px;
    text-align: right;
}
</style>

<script>
function togglePassword(inputId, iconEl) {
    const input = document.getElementById(inputId);
    const isHidden = input.type === 'password';
    input.type = isHidden ? 'text' : 'password';
    iconEl.innerHTML = isHidden
        ? '<path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z"/>'
        : '<path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>';
}

function checkPasswordStrength(value) {
    const bar    = document.getElementById('pwdStrengthBar');
    const fill   = document.getElementById('pwdStrengthFill');
    const label  = document.getElementById('pwdStrengthLabel');

    if (!value) { bar.style.display = 'none'; return; }
    bar.style.display = 'flex';

    let score = 0;
    if (value.length >= 8)               score++;
    if (/[A-Z]/.test(value))             score++;
    if (/[0-9]/.test(value))             score++;
    if (/[^A-Za-z0-9]/.test(value))      score++;

    const levels = [
        { w: '25%',  bg: '#c82014', text: 'Weak',   color: '#c82014' },
        { w: '50%',  bg: '#f59e0b', text: 'Fair',   color: '#f59e0b' },
        { w: '75%',  bg: '#006241', text: 'Good',   color: '#006241' },
        { w: '100%', bg: '#00754a', text: 'Strong', color: '#00754a' },
    ];

    const lvl = levels[Math.max(0, score - 1)];
    fill.style.width      = lvl.w;
    fill.style.background = lvl.bg;
    label.textContent     = lvl.text;
    label.style.color     = lvl.color;
}
</script>
