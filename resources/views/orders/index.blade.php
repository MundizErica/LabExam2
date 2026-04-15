@extends('layouts.app')

@section('title', 'Orders')
@section('page-title', 'Order Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="mb-0 fw-semibold">All Orders</h5>
        <small class="text-muted">Track and manage customer orders</small>
    </div>
    <a href="{{ route('orders.create') }}" class="btn btn-brand">
        <i class="bi bi-plus-lg me-1"></i> New Order
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-3">Order #</th>
                        <th>Customer</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Date</th>
                        <th class="pe-3 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td class="ps-3 fw-semibold text-muted">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td class="fw-500">{{ $order->customer_name }}</td>
                        <td class="text-muted small">{{ $order->items->count() }} item(s)</td>
                        <td class="fw-semibold text-success">₱{{ number_format($order->total_amount, 2) }}</td>
                        <td>
                            <span class="badge rounded-pill badge-{{ $order->status }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>
                            @if($order->payment)
                                <span class="badge rounded-pill badge-{{ $order->payment->status }}">
                                    {{ ucfirst($order->payment->status) }}
                                </span>
                            @else
                                <span class="text-muted small">–</span>
                            @endif
                        </td>
                        <td class="text-muted small">{{ $order->created_at->format('M d, Y') }}</td>
                        <td class="pe-3 text-end">
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-info me-1">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('orders.edit', $order) }}" class="btn btn-sm btn-outline-primary me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('orders.destroy', $order) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete Order #{{ $order->id }}?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="bi bi-cart-x" style="font-size:2rem;"></i>
                            <p class="mt-2 mb-0">No orders yet. <a href="{{ route('orders.create') }}">Create one</a></p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($orders->hasPages())
    <div class="card-footer bg-white">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
