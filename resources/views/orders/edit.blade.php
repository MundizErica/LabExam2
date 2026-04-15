@extends('layouts.app')

@section('title', 'Edit Order')
@section('page-title', 'Orders → Edit Order')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="d-flex align-items-center gap-2 mb-3">
            <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h5 class="mb-0 fw-semibold">Edit Order #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</h5>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <form action="{{ route('orders.update', $order) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-500">Customer Name <span class="text-danger">*</span></label>
                        <input type="text" name="customer_name"
                               class="form-control @error('customer_name') is-invalid @enderror"
                               value="{{ old('customer_name', $order->customer_name) }}">
                        @error('customer_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-500">Order Status</label>
                        <select name="status" class="form-select">
                            @foreach(['pending','completed','cancelled'] as $s)
                            <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>
                                {{ ucfirst($s) }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-500">Notes</label>
                        <textarea name="notes" rows="3" class="form-control">{{ old('notes', $order->notes) }}</textarea>
                    </div>

                    <!-- Read-only items summary -->
                    <div class="mb-4 p-3 rounded" style="background:#f9f9f9;">
                        <div class="fw-500 small mb-2 text-muted">ORDER ITEMS (read-only)</div>
                        @foreach($order->items as $item)
                        <div class="d-flex justify-content-between small mb-1">
                            <span>{{ $item->rice->name }} × {{ $item->quantity_kg }} kg</span>
                            <span class="text-success fw-semibold">₱{{ number_format($item->subtotal, 2) }}</span>
                        </div>
                        @endforeach
                        <hr class="my-2">
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total</span>
                            <span class="text-success">₱{{ number_format($order->total_amount, 2) }}</span>
                        </div>
                        <div class="text-muted" style="font-size:.75rem; margin-top:.4rem;">
                            To change items, delete this order and create a new one.
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-brand px-4">
                            <i class="bi bi-floppy me-1"></i> Save Changes
                        </button>
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
