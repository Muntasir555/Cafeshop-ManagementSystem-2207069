<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="BrewHaven Menu — Browse our full selection of coffees, teas, food, and more. Order online for pickup.">
    <title>Menu — BrewHaven Coffee</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
</head>
<body>

{{-- ════════════════════════════════════════════════════════
     NAVBAR
═══════════════════════════════════════════════════════════ --}}
<header class="menu-navbar">
    <div class="menu-nav-inner">

        {{-- Logo --}}
        <a href="/" class="menu-nav-logo" aria-label="BrewHaven Home">
            <svg class="menu-nav-logo-circle" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="50" cy="50" r="48" fill="#006241"/>
                <text x="50" y="38" text-anchor="middle" fill="white" font-family="Playfair Display,serif" font-size="11" font-weight="700" letter-spacing="2">BREW</text>
                <text x="50" y="58" text-anchor="middle" fill="white" font-family="Playfair Display,serif" font-size="22" font-weight="700">☕</text>
                <text x="50" y="74" text-anchor="middle" fill="white" font-family="Playfair Display,serif" font-size="9" letter-spacing="3">HAVEN</text>
            </svg>
            <span>BrewHaven</span>
        </a>

        {{-- Nav Links --}}
        <nav class="menu-nav-links">
            <a href="{{ url('/') }}">Home</a>
            <a href="{{ route('menu') }}" class="active">Menu</a>
            <a href="{{ url('/#rewards-strip') }}">Rewards</a>
            <a href="{{ url('/#store-section') }}">Find a Store</a>
        </nav>

        <div class="menu-nav-actions">
            {{-- Cart Button --}}
            <button class="nav-cart-btn" id="openCartBtn" aria-label="Open cart" title="View cart">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/>
                </svg>
                <span class="nav-cart-badge" id="navCartBadge">0</span>
            </button>

            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="btn-nav-signin">Admin</a>
                @else
                    <a href="{{ route('dashboard') }}" class="btn-nav-signin">My Account</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" class="btn-nav-join">Log out</a>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-nav-signin">Sign in</a>
                <a href="{{ route('register') }}" class="btn-nav-join">Join now</a>
            @endauth
        </div>

    </div>
</header>

{{-- ════════════════════════════════════════════════════════
     HERO STRIP
═══════════════════════════════════════════════════════════ --}}
<div class="menu-hero-strip">
    <h1>Our Full Menu</h1>
    <p>Handcrafted drinks, fresh food, and exclusive merchandise</p>
</div>

{{-- ════════════════════════════════════════════════════════
     MAIN LAYOUT: SIDEBAR + PRODUCT GRID
═══════════════════════════════════════════════════════════ --}}
<div class="menu-layout">

    {{-- ─── SIDEBAR ─────────────────────────────────────── --}}
    <aside class="menu-sidebar" id="menuSidebar">
        <div class="sidebar-title">Browse Menu</div>
        <nav class="sidebar-nav" id="sidebarNav">

            {{-- "All Items" link --}}
            <button class="sidebar-link active" data-filter="all" onclick="filterCategory('all', this)">
                <span class="sidebar-icon">☰</span>
                All Items
                <span class="sidebar-count">{{ $products->count() }}</span>
            </button>

            {{-- Per-category links --}}
            @php
                $categoryIcons = [
                    'Cold Drinks'    => '🧊',
                    'Hot Drinks'     => '☕',
                    'Frappuccino'    => '🥤',
                    'Teas & Chai'    => '🍵',
                    'Bakery'         => '🥐',
                    'Food & Snacks'  => '🥗',
                    'Merchandise'    => '🛍️',
                    'Gift Cards'     => '🎁',
                ];
            @endphp

            @foreach($categories as $cat)
                @php $count = $grouped->get($cat, collect())->count(); @endphp
                @if($count > 0)
                <button class="sidebar-link" data-filter="{{ $cat }}" onclick="filterCategory('{{ addslashes($cat) }}', this)">
                    <span class="sidebar-icon">{{ $categoryIcons[$cat] ?? '🍽️' }}</span>
                    {{ $cat }}
                    <span class="sidebar-count">{{ $count }}</span>
                </button>
                @endif
            @endforeach

        </nav>
    </aside>

    {{-- ─── PRODUCT PANEL ───────────────────────────────── --}}
    <main class="menu-panel" id="menuPanel">

        @if($products->isEmpty())
            <div class="menu-empty">
                <div class="menu-empty-icon">☕</div>
                <h2>Menu Coming Soon</h2>
                <p>Our baristas are working on something special. Check back shortly!</p>
            </div>
        @else

            {{-- Render one section per category --}}
            @foreach($categories as $cat)
                @php $catProducts = $grouped->get($cat, collect()); @endphp
                @if($catProducts->count() > 0)
                <section class="menu-category-section" id="section-{{ Str::slug($cat) }}" data-category="{{ $cat }}">

                    <div class="category-heading">
                        <h2>{{ $cat }}</h2>
                        <span class="category-count-pill">{{ $catProducts->count() }} item{{ $catProducts->count() !== 1 ? 's' : '' }}</span>
                    </div>

                    <div class="products-grid">
                        @foreach($catProducts as $product)
                        <article class="product-card"
                                 id="product-{{ $product->id }}"
                                 onclick="openProductDetail({{ $product->id }})">

                            {{-- Product Image --}}
                            <div class="product-img-wrap">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                         alt="{{ $product->name }}"
                                         class="product-img"
                                         loading="lazy">
                                @else
                                    <div class="product-img-placeholder">
                                        {{ $categoryIcons[$product->category] ?? '☕' }}
                                    </div>
                                @endif

                                @if($product->badge)
                                    <span class="product-badge badge-{{ Str::slug($product->badge) }}">
                                        {{ $product->badge }}
                                    </span>
                                @endif
                            </div>

                            {{-- Card Body --}}
                            <div class="product-body">
                                <h3 class="product-name">{{ $product->name }}</h3>

                                @if($product->calories)
                                    <p class="product-calories">{{ $product->calories }} calories</p>
                                @endif

                                @if($product->description)
                                    <p class="product-desc">{{ $product->description }}</p>
                                @endif

                                <div class="product-footer">
                                    <span class="product-price">${{ number_format($product->price, 2) }}</span>
                                    <button class="btn-add-to-cart"
                                            title="Add {{ $product->name }} to order"
                                            onclick="event.stopPropagation(); addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, '{{ $product->image ? asset('storage/' . $product->image) : '' }}')">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                                    </button>
                                </div>
                            </div>

                        </article>
                        @endforeach
                    </div>

                </section>
                @endif
            @endforeach

        @endif
    </main>

</div>{{-- /.menu-layout --}}


{{-- ════════════════════════════════════════════════════════
     CART OVERLAY + DRAWER
═══════════════════════════════════════════════════════════ --}}
<div class="cart-overlay" id="cartOverlay" onclick="closeCart()"></div>

<div class="cart-drawer" id="cartDrawer" role="dialog" aria-modal="true" aria-label="Your Order">

    {{-- Drawer Header --}}
    <div class="cart-header">
        <h2>🛒 Your Order</h2>
        <button class="cart-close-btn" onclick="closeCart()" aria-label="Close cart">✕</button>
    </div>

    {{-- Items List --}}
    <div class="cart-items" id="cartItems">
        <div class="cart-empty-msg" id="cartEmptyMsg">
            <span>🛒</span>
            <p>Your order is empty.<br>Add some items from the menu!</p>
        </div>
    </div>

    {{-- Footer: Summary + Checkout --}}
    <div class="cart-footer" id="cartFooter" style="display:none;">

        <div class="cart-summary">
            <div class="cart-summary-row">
                <span>Subtotal</span>
                <span id="cartSubtotal">$0.00</span>
            </div>
            <div class="cart-summary-row total">
                <span>Total</span>
                <span id="cartTotal">$0.00</span>
            </div>
        </div>

        <form class="checkout-form" id="checkoutForm">
            @csrf
            <input type="text"
                   id="customerName"
                   placeholder="Your full name *"
                   required
                   @auth value="{{ auth()->user()->name }}" @endauth>
            <input type="email"
                   id="customerEmail"
                   placeholder="Your email *"
                   required
                   @auth value="{{ auth()->user()->email }}" @endauth>
            <textarea id="orderNotes" placeholder="Special instructions (optional)…"></textarea>
            <div class="form-error-msg" id="checkoutError"></div>
            <button type="submit" class="btn-place-order" id="placeOrderBtn">
                Place Order
            </button>
        </form>

    </div>
</div>


{{-- ════════════════════════════════════════════════════════
     SUCCESS MODAL
═══════════════════════════════════════════════════════════ --}}
<div class="success-overlay" id="successOverlay">
    <div class="success-modal">
        <div class="success-check">✓</div>
        <h2>Order Placed!</h2>
        <p>Thanks for your order. We'll have it ready shortly.</p>
        <div class="success-order-id" id="successOrderId">#</div>
        <p style="font-size:.82rem; color:#999; margin-bottom:24px;">
            Keep your order number handy. You'll receive a confirmation at<br>
            <strong id="successEmail"></strong>
        </p>
        <button class="btn-success-close" onclick="closeSuccess()">Back to Menu</button>
    </div>
</div>


{{-- ════════════════════════════════════════════════════════
     TOAST
═══════════════════════════════════════════════════════════ --}}
<div class="menu-toast" id="menuToast">
    <span>✓</span>
    <span id="toastMsg">Added to your order!</span>
</div>


{{-- ════════════════════════════════════════════════════════
     JAVASCRIPT
═══════════════════════════════════════════════════════════ --}}
<script>
/* ─── State ───────────────────────────────────────────── */
const cart   = {}; // { productId: { id, name, price, image, qty } }
const ORDERS_URL = "{{ route('orders.store') }}";
const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').content;

/* ─── Category Filter ────────────────────────────────── */
function filterCategory(category, btn) {
    // Update sidebar active state
    document.querySelectorAll('.sidebar-link').forEach(l => l.classList.remove('active'));
    btn.classList.add('active');

    const sections = document.querySelectorAll('.menu-category-section');

    if (category === 'all') {
        sections.forEach(s => s.removeAttribute('data-hidden'));
    } else {
        sections.forEach(s => {
            if (s.dataset.category === category) {
                s.removeAttribute('data-hidden');
                // Smooth scroll to section
                s.scrollIntoView({ behavior: 'smooth', block: 'start' });
            } else {
                s.setAttribute('data-hidden', 'true');
            }
        });
    }
}

/* ─── Cart Logic ─────────────────────────────────────── */
function addToCart(id, name, price, image) {
    if (cart[id]) {
        cart[id].qty++;
    } else {
        cart[id] = { id, name, price: parseFloat(price), image, qty: 1 };
    }
    renderCart();
    updateNavBadge();
    showToast(`Added "${name}" to your order!`);
}

function changeQty(id, delta) {
    if (!cart[id]) return;
    cart[id].qty += delta;
    if (cart[id].qty <= 0) {
        delete cart[id];
    }
    renderCart();
    updateNavBadge();
}

function renderCart() {
    const container  = document.getElementById('cartItems');
    const emptyMsg   = document.getElementById('cartEmptyMsg');
    const footer     = document.getElementById('cartFooter');
    const subtotalEl = document.getElementById('cartSubtotal');
    const totalEl    = document.getElementById('cartTotal');

    const items = Object.values(cart);

    if (items.length === 0) {
        // Show empty state; remove all item nodes first
        container.querySelectorAll('.cart-item').forEach(el => el.remove());
        emptyMsg.style.display = 'flex';
        footer.style.display   = 'none';
        return;
    }

    emptyMsg.style.display = 'none';
    footer.style.display   = 'block';

    // Re-render all items
    container.querySelectorAll('.cart-item').forEach(el => el.remove());

    let subtotal = 0;

    items.forEach(item => {
        subtotal += item.price * item.qty;
        const div = document.createElement('div');
        div.className = 'cart-item';
        div.id = `cart-item-${item.id}`;
        div.innerHTML = `
            <div class="cart-item-img">
                ${item.image
                    ? `<img src="${item.image}" alt="${escHtml(item.name)}">`
                    : `<span style="font-size:1.8rem">☕</span>`}
            </div>
            <div class="cart-item-info">
                <div class="cart-item-name">${escHtml(item.name)}</div>
                <div class="cart-item-price">$${item.price.toFixed(2)} each</div>
            </div>
            <div class="cart-item-qty">
                <button class="qty-btn" onclick="changeQty(${item.id}, -1)" aria-label="Remove one">−</button>
                <span class="qty-num">${item.qty}</span>
                <button class="qty-btn" onclick="changeQty(${item.id}, 1)" aria-label="Add one">+</button>
            </div>
            <div class="cart-item-total">$${(item.price * item.qty).toFixed(2)}</div>
        `;
        // Insert before empty message
        container.insertBefore(div, emptyMsg);
    });

    subtotalEl.textContent = `$${subtotal.toFixed(2)}`;
    totalEl.textContent    = `$${subtotal.toFixed(2)}`;
}

function updateNavBadge() {
    const badge    = document.getElementById('navCartBadge');
    const totalQty = Object.values(cart).reduce((sum, i) => sum + i.qty, 0);
    badge.textContent = totalQty;
    badge.classList.toggle('has-items', totalQty > 0);
}

/* ─── Cart Drawer open/close ─────────────────────────── */
function openCart() {
    document.getElementById('cartOverlay').classList.add('open');
    document.getElementById('cartDrawer').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeCart() {
    document.getElementById('cartOverlay').classList.remove('open');
    document.getElementById('cartDrawer').classList.remove('open');
    document.body.style.overflow = '';
}

document.getElementById('openCartBtn').addEventListener('click', openCart);

/* ─── Checkout Form Submit ───────────────────────────── */
document.getElementById('checkoutForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const name  = document.getElementById('customerName').value.trim();
    const email = document.getElementById('customerEmail').value.trim();
    const notes = document.getElementById('orderNotes').value.trim();
    const errEl = document.getElementById('checkoutError');
    const btn   = document.getElementById('placeOrderBtn');

    errEl.classList.remove('show');

    const items = Object.values(cart);
    if (items.length === 0) {
        showCheckoutError('Your cart is empty.');
        return;
    }

    btn.disabled    = true;
    btn.textContent = 'Placing order…';

    try {
        const response = await fetch(ORDERS_URL, {
            method:  'POST',
            headers: {
                'Content-Type':     'application/json',
                'X-CSRF-TOKEN':     CSRF_TOKEN,
                'Accept':           'application/json',
            },
            body: JSON.stringify({
                customer_name:  name,
                customer_email: email,
                notes:          notes || null,
                items:          items.map(i => ({
                    id:    i.id,
                    name:  i.name,
                    price: i.price,
                    qty:   i.qty,
                })),
            }),
        });

        const data = await response.json();

        if (!response.ok) {
            // Laravel validation errors come as { errors: { field: [...] } }
            const msgs = data.errors
                ? Object.values(data.errors).flat().join(' ')
                : (data.message || 'Something went wrong. Please try again.');
            showCheckoutError(msgs);
            return;
        }

        // Success! We get a Stripe Checkout URL back.
        // Instead of local modal, we redirect them to Stripe to pay.
        if (data.checkout_url) {
            window.location.href = data.checkout_url;
            return; // Exit here, the browser will leave the page.
        }

        // Fallback (shouldn't happen with Stripe enabled, but safe to keep)
        closeCart();
        showSuccess(data.order_id, email);

        // Clear cart
        Object.keys(cart).forEach(k => delete cart[k]);
        renderCart();
        updateNavBadge();

    } catch (err) {
        showCheckoutError('Network error. Please check your connection.');
    } finally {
        btn.disabled    = false;
        btn.textContent = 'Place Order';
    }
});

function showCheckoutError(msg) {
    const errEl = document.getElementById('checkoutError');
    errEl.textContent = msg;
    errEl.classList.add('show');
}

/* ─── Success Modal ──────────────────────────────────── */
function showSuccess(orderId, email) {
    document.getElementById('successOrderId').textContent = '#' + orderId;
    document.getElementById('successEmail').textContent   = email;
    document.getElementById('successOverlay').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeSuccess() {
    document.getElementById('successOverlay').classList.remove('open');
    document.body.style.overflow = '';
}

/* ─── Toast ──────────────────────────────────────────── */
function showToast(msg) {
    const toast = document.getElementById('menuToast');
    document.getElementById('toastMsg').textContent = msg;
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 2800);
}

/* ─── Helper: escape HTML ────────────────────────────── */
function escHtml(str) {
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

/* ─── Keyboard: close drawer on Escape ──────────────── */
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        closeCart();
        closeSuccess();
    }
});

/* ─── Product detail (future: open modal) ──────────── */
function openProductDetail(id) {
    // Placeholder — card click can open a detail modal in a future step
}

/* ─── On page load: honour ?category= URL param ─────── */
(function () {
    const params   = new URLSearchParams(window.location.search);
    const category = params.get('category');
    if (category) {
        const btn = [...document.querySelectorAll('.sidebar-link')]
            .find(b => b.dataset.filter === category);
        if (btn) {
            filterCategory(category, btn);
        }
    }
})();
</script>

</body>
</html>
