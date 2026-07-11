@extends('admin.layout')
@section('title', 'Products')
@section('breadcrumb', 'Products')

@section('content')
<div class="page-title-row">
    <div>
        <h1 class="page-title">Menu Products</h1>
        <p class="page-subtitle">Manage your cafe's menu items, availability, and pricing.</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn-primary">
        <svg viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
        Add Product
    </a>
</div>

<!-- Filters -->
<div class="admin-card filter-card">
    <form method="GET" action="{{ route('admin.products.index') }}" class="filter-form">
        <div class="filter-group">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search products…" class="filter-input">
        </div>
        <div class="filter-group">
            <select name="category" class="filter-select">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn-secondary">Filter</button>
        @if(request('search') || request('category'))
            <a href="{{ route('admin.products.index') }}" class="btn-ghost">Clear</a>
        @endif
    </form>
</div>

<!-- Products Table -->
<div class="admin-card">
    <div class="table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Calories</th>
                    <th>Badge</th>
                    <th>Available</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr id="product-row-{{ $product->id }}">
                    <td>
                        <div class="product-cell">
                            <div class="product-thumb">
                                @if($product->image)
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                                @else
                                    <span class="product-thumb-placeholder">☕</span>
                                @endif
                            </div>
                            <div>
                                <span class="product-name">{{ $product->name }}</span>
                                <span class="product-desc-short">{{ Str::limit($product->description, 55) }}</span>
                            </div>
                        </div>
                    </td>
                    <td><span class="cat-pill">{{ $product->category }}</span></td>
                    <td class="td-total">${{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->calories ? $product->calories . ' cal' : '—' }}</td>
                    <td>
                        @if($product->badge)
                            <span class="badge-pill">{{ $product->badge }}</span>
                        @else
                            <span class="td-empty-inline">—</span>
                        @endif
                    </td>
                    <td>
                        <button
                            class="toggle-btn {{ $product->is_available ? 'toggle-on' : 'toggle-off' }}"
                            onclick="toggleAvailability({{ $product->id }}, this)"
                            data-id="{{ $product->id }}"
                            title="{{ $product->is_available ? 'Click to hide' : 'Click to show' }}">
                            <span class="toggle-knob"></span>
                        </button>
                    </td>
                    <td>
                        <div class="action-btns">
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn-table">Edit</a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                  onsubmit="return confirm('Delete {{ addslashes($product->name) }}? This cannot be undone.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-table btn-danger">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="td-empty">No products found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
    <div class="pagination-wrap">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function toggleAvailability(id, btn) {
    fetch(`/admin/products/${id}/toggle`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        }
    })
    .then(r => r.json())
    .then(data => {
        btn.classList.toggle('toggle-on', data.is_available);
        btn.classList.toggle('toggle-off', !data.is_available);
        btn.title = data.is_available ? 'Click to hide' : 'Click to show';
    });
}
</script>
@endpush
