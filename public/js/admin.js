/* ============================================================
   BrewHaven Admin — JavaScript
   ============================================================ */

/* ── Sidebar Toggle ───────────────────────────────────────── */
function toggleSidebar() {
    const sidebar  = document.getElementById('adminSidebar');
    const overlay  = document.getElementById('sidebarOverlay');
    const isOpen   = sidebar.classList.contains('open');

    sidebar.classList.toggle('open', !isOpen);
    overlay.classList.toggle('open', !isOpen);
    document.body.style.overflow = isOpen ? '' : 'hidden';
}

/* ── Auto-dismiss flash messages after 4s ─────────────────── */
(function () {
    const flash = document.getElementById('flashMsg');
    if (flash) {
        setTimeout(() => {
            flash.style.transition = 'opacity 0.4s';
            flash.style.opacity    = '0';
            setTimeout(() => flash.remove(), 400);
        }, 4000);
    }
})();

/* ── Confirm delete ───────────────────────────────────────── */
document.querySelectorAll('form[data-confirm]').forEach(form => {
    form.addEventListener('submit', function (e) {
        if (!confirm(this.dataset.confirm)) e.preventDefault();
    });
});

/* ── Active nav highlight on page load ────────────────────── */
(function () {
    const links = document.querySelectorAll('.sidebar-link');
    links.forEach(link => {
        if (link.href === window.location.href) {
            link.classList.add('active');
        }
    });
})();

/* ── Table row hover highlight ────────────────────────────── */
document.querySelectorAll('.admin-table tbody tr').forEach(row => {
    row.addEventListener('mouseenter', () => row.style.background = '#f5faf8');
    row.addEventListener('mouseleave', () => row.style.background = '');
});
