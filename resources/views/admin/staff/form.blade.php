@extends('admin.layout')
@section('title', isset($staff) ? 'Edit Staff' : 'Add Staff')
@section('breadcrumb', isset($staff) ? 'Edit Staff' : 'Add Staff')

@section('content')
<div class="page-title-row">
    <div>
        <h1 class="page-title">{{ isset($staff) ? 'Edit Staff Member' : 'Add New Staff Member' }}</h1>
        <p class="page-subtitle">{{ isset($staff) ? 'Update details for ' . $staff->name : 'Fill in the details to add a new team member.' }}</p>
    </div>
    <a href="{{ route('admin.staff.index') }}" class="btn-secondary">← Back to Staff</a>
</div>

<div class="admin-card form-card">
    <form method="POST"
          action="{{ isset($staff) ? route('admin.staff.update', $staff) : route('admin.staff.store') }}"
          enctype="multipart/form-data">
        @csrf
        @if(isset($staff)) @method('PUT') @endif

        @if($errors->any())
        <div class="form-errors">
            <strong>Please fix the following errors:</strong>
            <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
        @endif

        <div class="form-grid">

            {{-- Name --}}
            <div class="form-group">
                <label class="form-label" for="name">Full Name <span class="required">*</span></label>
                <input type="text" name="name" id="name"
                       class="form-input @error('name') is-error @enderror"
                       value="{{ old('name', $staff->name ?? '') }}" required
                       placeholder="e.g. James Rivera">
                @error('name')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            {{-- Email --}}
            <div class="form-group">
                <label class="form-label" for="email">Email <span class="required">*</span></label>
                <input type="email" name="email" id="email"
                       class="form-input @error('email') is-error @enderror"
                       value="{{ old('email', $staff->email ?? '') }}" required
                       placeholder="staff@brewhaven.com">
                @error('email')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            {{-- Phone --}}
            <div class="form-group">
                <label class="form-label" for="phone">Phone</label>
                <input type="text" name="phone" id="phone"
                       class="form-input"
                       value="{{ old('phone', $staff->phone ?? '') }}"
                       placeholder="+1 (555) 000-0000">
            </div>

            {{-- Role --}}
            <div class="form-group">
                <label class="form-label" for="role">Role <span class="required">*</span></label>
                <select name="role" id="role" class="form-select @error('role') is-error @enderror" required>
                    <option value="">Select role…</option>
                    @foreach($roles as $key => $meta)
                        <option value="{{ $key }}" {{ old('role', $staff->role ?? '') === $key ? 'selected' : '' }}>
                            {{ $meta['label'] }}
                        </option>
                    @endforeach
                </select>
                @error('role')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            {{-- Shift --}}
            <div class="form-group">
                <label class="form-label" for="shift">Shift <span class="required">*</span></label>
                <select name="shift" id="shift" class="form-select @error('shift') is-error @enderror" required>
                    <option value="">Select shift…</option>
                    @foreach($shifts as $key => $label)
                        <option value="{{ $key }}" {{ old('shift', $staff->shift ?? '') === $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('shift')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            {{-- Store --}}
            <div class="form-group">
                <label class="form-label" for="store_id">Assigned Store</label>
                <select name="store_id" id="store_id" class="form-select">
                    <option value="">Not assigned</option>
                    @foreach($stores as $store)
                        <option value="{{ $store->id }}"
                            {{ old('store_id', $staff->store_id ?? '') == $store->id ? 'selected' : '' }}>
                            {{ $store->name }} — {{ $store->city }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Monthly Salary --}}
            <div class="form-group">
                <label class="form-label" for="monthly_salary">Monthly Salary ($) <span class="required">*</span></label>
                <input type="number" name="monthly_salary" id="monthly_salary"
                       class="form-input @error('monthly_salary') is-error @enderror"
                       value="{{ old('monthly_salary', $staff->monthly_salary ?? '') }}"
                       required step="0.01" min="0" placeholder="1800.00">
                @error('monthly_salary')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            {{-- Join Date --}}
            <div class="form-group">
                <label class="form-label" for="join_date">Join Date <span class="required">*</span></label>
                <input type="date" name="join_date" id="join_date"
                       class="form-input @error('join_date') is-error @enderror"
                       value="{{ old('join_date', isset($staff) ? $staff->join_date->format('Y-m-d') : '') }}" required>
                @error('join_date')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            {{-- Status --}}
            <div class="form-group">
                <label class="form-label" for="status">Status <span class="required">*</span></label>
                <select name="status" id="status" class="form-select" required>
                    @foreach($statuses as $key => $meta)
                        <option value="{{ $key }}" {{ old('status', $staff->status ?? 'active') === $key ? 'selected' : '' }}>
                            {{ $meta['label'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Photo --}}
            <div class="form-group form-full">
                <label class="form-label" for="photo">Profile Photo</label>
                @if(isset($staff) && $staff->photo)
                    <div class="current-image-wrap">
                        <img src="{{ asset('storage/' . $staff->photo) }}" alt="{{ $staff->name }}" class="current-image">
                        <span class="current-image-label">Current photo</span>
                    </div>
                @endif
                <input type="file" name="photo" id="photo" class="form-file" accept="image/*">
                <p class="form-hint">Max 2MB. Supported: JPG, PNG, WebP.</p>
            </div>

            {{-- Notes --}}
            <div class="form-group form-full">
                <label class="form-label" for="notes">Notes</label>
                <textarea name="notes" id="notes" class="form-textarea" rows="3"
                          placeholder="Any additional notes about this staff member…">{{ old('notes', $staff->notes ?? '') }}</textarea>
            </div>

        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">
                {{ isset($staff) ? 'Update Staff Member' : 'Add Staff Member' }}
            </button>
            <a href="{{ route('admin.staff.index') }}" class="btn-ghost">Cancel</a>
        </div>
    </form>
</div>
@endsection
