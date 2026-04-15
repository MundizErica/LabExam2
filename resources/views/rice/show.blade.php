@extends('layouts.app')

@section('title', $rice->name)
@section('page-title', 'Rice Menu → Product Detail')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="d-flex align-items-center gap-2 mb-3">
            <a href="{{ route('rice.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h5 class="mb-0 fw-semibold">{{ $rice->name }}</h5>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div style="width:56px;height:56px;background:#e8f5e9;border-radius:14px;
                                display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-bag-heart text-success" style="font-size:1.6rem;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">{{ $rice->name }}</h5>
                        <span class="text-muted small">Rice Product #{{ $rice->id }}</span>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="p-3 rounded" style="background:#f9f9f9;">
                            <div class="text-muted small mb-1">Price per Kilogram</div>
                            <div class="fw-bold text-success fs-5">₱{{ number_format($rice->price_per_kg, 2) }}</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 rounded" style="background:#f9f9f9;">
                            <div class="text-muted small mb-1">Stock Quantity</div>
                            <div class="fw-bold fs-5 {{ $rice->stock_quantity < 10 ? 'text-warning' : 'text-dark' }}">
                                {{ $rice->stock_quantity }} kg
                                @if($rice->stock_quantity < 10)
                                    <span class="badge bg-warning text-dark ms-1" style="font-size:.65rem;">Low Stock</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 rounded" style="background:#f9f9f9;">
                            <div class="text-muted small mb-1">Description</div>
                            <div>{{ $rice->description ?? 'No description provided.' }}</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 rounded" style="background:#f9f9f9;">
                            <div class="text-muted small mb-1">Date Added</div>
                            <div class="fw-500">{{ $rice->created_at->format('F d, Y') }}</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 rounded" style="background:#f9f9f9;">
                            <div class="text-muted small mb-1">Last Updated</div>
                            <div class="fw-500">{{ $rice->updated_at->format('F d, Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('rice.edit', $rice) }}" class="btn btn-brand">
                <i class="bi bi-pencil me-1"></i> Edit Item
            </a>
            <form action="{{ route('rice.destroy', $rice) }}" method="POST"
                  onsubmit="return confirm('Delete {{ $rice->name }}? This cannot be undone.')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-outline-danger">
                    <i class="bi bi-trash me-1"></i> Delete
                </button>
            </form>
            <a href="{{ route('rice.index') }}" class="btn btn-outline-secondary">Back to List</a>
        </div>
    </div>
</div>
@endsection
