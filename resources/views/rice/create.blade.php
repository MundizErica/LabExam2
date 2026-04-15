@extends('layouts.app')

@section('title', 'Add Rice Item')
@section('page-title', 'Rice Menu → Add New Item')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="d-flex align-items-center gap-2 mb-3">
            <a href="{{ route('rice.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h5 class="mb-0 fw-semibold">Add New Rice Item</h5>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <form action="{{ route('rice.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-500">Rice Name <span class="text-danger">*</span></label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}"
                               placeholder="e.g. Jasmine Rice, Dinorado, Brown Rice">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-500">Price per Kilogram (₱) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="number" name="price_per_kg" step="0.01" min="0"
                                       class="form-control @error('price_per_kg') is-invalid @enderror"
                                       value="{{ old('price_per_kg') }}" placeholder="0.00">
                                @error('price_per_kg') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-500">Stock Quantity (kg) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" name="stock_quantity" step="0.01" min="0"
                                       class="form-control @error('stock_quantity') is-invalid @enderror"
                                       value="{{ old('stock_quantity') }}" placeholder="0">
                                <span class="input-group-text">kg</span>
                                @error('stock_quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-500">Description</label>
                        <textarea name="description" rows="3"
                                  class="form-control @error('description') is-invalid @enderror"
                                  placeholder="Short description of this rice variety...">{{ old('description') }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-brand px-4">
                            <i class="bi bi-floppy me-1"></i> Save Rice Item
                        </button>
                        <a href="{{ route('rice.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
