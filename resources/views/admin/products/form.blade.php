@extends('admin.layout')
@section('title', isset($product) ? 'Edit Product' : 'Add Product')
@section('breadcrumb', isset($product) ? 'Edit Product' : 'Add Product')

@section('content')
<div class="page-title-row">
    <div>
        <h1 class="page-title">{{ isset($product) ? 'Edit Product' : 'Add New Product' }}</h1>
        <p class="page-subtitle">{{ isset($product) ? 'Update the details for ' . $product->name : 'Add a new item to the menu.' }}</p>
    </div>
    <a href="{{ route('admin.products.index') }}" class="btn-secondary">← Back to Products</a>
</div>

<div class="admin-card form-card">
    <form method="POST"
          action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}"
          enctype="multipart/form-data">
        @csrf
        @if(isset($product)) @method('PUT') @endif

        @if($errors->any())
        <div class="form-errors">
            <strong>Please fix the following errors:</strong>
            <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
        @endif

        <div class="form-grid">
            <!-- Name -->
            <div class="form-group form-full">
                <label class="form-label" for="name">Product Name <span class="required">*</span></label>
                <input type="text" name="name" id="name" class="form-input @error('name') is-error @enderror"
                       value="{{ old('name', $product->name ?? '') }}" required placeholder="e.g. Iced Caramel Macchiato">
                @error('name')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <!-- Category -->
            <div class="form-group">
                <label class="form-label" for="category">Category <span class="required">*</span></label>
                <select name="category" id="category" class="form-select @error('category') is-error @enderror" required>
                    <option value="">Select category…</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ old('category', $product->category ?? '') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
                @error('category')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <!-- Badge -->
            <div class="form-group">
                <label class="form-label" for="badge">Badge</label>
                <select name="badge" id="badge" class="form-select">
                    <option value="">No badge</option>
                    @foreach($badges as $b)
                        <option value="{{ $b }}" {{ old('badge', $product->badge ?? '') === $b ? 'selected' : '' }}>{{ $b }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Price -->
            <div class="form-group">
                <label class="form-label" for="price">Price ($) <span class="required">*</span></label>
                <input type="number" name="price" id="price" class="form-input @error('price') is-error @enderror"
                       value="{{ old('price', $product->price ?? '') }}" required step="0.01" min="0" placeholder="5.75">
                @error('price')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <!-- Calories -->
            <div class="form-group">
                <label class="form-label" for="calories">Calories</label>
                <input type="number" name="calories" id="calories" class="form-input"
                       value="{{ old('calories', $product->calories ?? '') }}" min="0" placeholder="250">
            </div>

            <!-- Description -->
            <div class="form-group form-full">
                <label class="form-label" for="description">Description</label>
                <textarea name="description" id="description" class="form-textarea" rows="3"
                          placeholder="Describe this product…">{{ old('description', $product->description ?? '') }}</textarea>
            </div>

            <!-- Image Upload -->
            <div class="form-group form-full">
                <label class="form-label" for="image">Product Image</label>
                @if(isset($product) && $product->image)
                    <div class="current-image-wrap">
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="current-image">
                        <span class="current-image-label">Current image</span>
                    </div>
                @endif
                <input type="file" name="image" id="image" class="form-file" accept="image/*">
                <p class="form-hint">Max 2MB. Supported: JPG, PNG, WebP.</p>
            </div>

            <!-- Availability Toggle -->
            <div class="form-group form-full">
                <label class="form-label form-label-inline">
                    <input type="hidden" name="is_available" value="0">
                    <input type="checkbox" name="is_available" value="1" class="form-checkbox"
                           {{ old('is_available', $product->is_available ?? true) ? 'checked' : '' }}>
                    <span>Available on menu</span>
                    <span class="form-hint-inline">Uncheck to hide this item from customers.</span>
                </label>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">
                {{ isset($product) ? 'Update Product' : 'Create Product' }}
            </button>
            <a href="{{ route('admin.products.index') }}" class="btn-ghost">Cancel</a>
        </div>
    </form>
</div>
@endsection
