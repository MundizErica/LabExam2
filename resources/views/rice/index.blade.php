@extends('layouts.app')

@section('title', 'Rice Menu')
@section('page-title', 'Rice Menu Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="mb-0 fw-semibold">Rice Products</h5>
        <small class="text-muted">Manage your rice inventory</small>
    </div>
    <a href="{{ route('rice.create') }}" class="btn btn-brand">
        <i class="bi bi-plus-lg me-1"></i> Add Rice Item
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-3">#</th>
                        <th>Rice Name</th>
                        <th>Price / kg</th>
                        <th>Stock (kg)</th>
                        <th>Description</th>
                        <th class="pe-3 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riceItems as $rice)
                    <tr>
                        <td class="ps-3 text-muted">{{ $rice->id }}</td>
                        <td class="fw-500">
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:34px; height:34px; background:#e8f5e9;
                                            border-radius:8px; display:flex;
                                            align-items:center; justify-content:center;">
                                    <i class="bi bi-bag-heart text-success" style="font-size:.85rem;"></i>
                                </div>
                                {{ $rice->name }}
                            </div>
                        </td>
                        <td class="text-success fw-semibold">₱{{ number_format($rice->price_per_kg, 2) }}</td>
                        <td>
                            @if($rice->stock_quantity < 10)
                                <span class="badge bg-warning text-dark">{{ $rice->stock_quantity }} kg</span>
                            @else
                                <span class="text-dark">{{ $rice->stock_quantity }} kg</span>
                            @endif
                        </td>
                        <td class="text-muted small" style="max-width:220px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                            {{ $rice->description ?? '–' }}
                        </td>
                        <td class="pe-3 text-end">
                            <a href="{{ route('rice.edit', $rice) }}" class="btn btn-sm btn-outline-primary me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('rice.destroy', $rice) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete {{ $rice->name }}?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox" style="font-size:2rem;"></i>
                            <p class="mt-2 mb-0">No rice items yet. <a href="{{ route('rice.create') }}">Add one</a></p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($riceItems->hasPages())
    <div class="card-footer bg-white border-top-0 pt-0">
        {{ $riceItems->links() }}
    </div>
    @endif
</div>
@endsection
